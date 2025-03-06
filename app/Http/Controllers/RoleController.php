<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return[
            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:edit roles', only: ['edit']),
            new Middleware('permission:create roles', only: ['create']),
            new Middleware('permission:delete roles', only: ['destroy']),

        ];
    }
    //    This Method Will Show Permission Page
    public function index()
    {
        return view('backend.employee.roles.list');

        /*$roles=Role::orderBy('name','ASC')->paginate(10);
        return view('roles.list',[
            'roles'=>$roles
        ]);*/


    }


    public function fetch() {

       $roles=Role::orderBy('name','ASC')->get();
        $output = '';
        if ($roles->count() > 0) {
            $output .= '<table class="table table-striped table-lg text-center align-middle">
            <thead>
              <tr>
                <th>Name</th>
                <th>Permissions</th>
                <th>Created_at</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($roles as $role) {
                $output .= '<tr>
                <td>' . $role->name . '</td>
                <td>' . $role->permissions->pluck('name')->implode(', ') . '</td>
                 <td>' . $role->created_at->format("Y-m-d") . '</td>
                <td>
                  <a href="' . route('roles.edit', $role->id) . '"  class="text-success mx-1 editIcon"><i class="fa-regular fa-pen-to-square text-warning"></i></a>

                  <a href="" id="' . $role->id . '" class="text-danger mx-1 deleteIcon"><i class="fa-solid fa-trash"></i></a>

                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }
//    This Method Will Show Create Permission Page
    public function create()
    {
        $permissions=Permission::orderBy('name','desc')->get();
        return view('backend.employee.roles.create',[
            'permissions'=>$permissions
        ]);
    }
//    This Method Will Store Permission
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|unique:roles|min:3',
        ]);

        if($validator->passes())
        {
            $role = Role::create([
                'name'=>$request->name
            ]);
            if(!empty($request->permission)){
                foreach ($request->permission as $name){
                    $role->givePermissionTo($name);
                }
            }
            notify()->success('Role addedd successfully');
            return redirect()->route('roles.index')->with('success','Role Added Successfully');

        }
        else
        {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

//    This Method Will find updated Record
    public function edit($id)
    {
        $role=Role::findOrFail($id);
        $haspermissions = $role->permissions->pluck('name');
        $permissions=Permission::orderBy('name','ASC')->get();

        return view('backend.employee.roles.edit',[
            'permissions'=>$permissions,
            'haspermissions'=>$haspermissions,
            'role'=>$role
        ]);

    }
//    This Method Will update Permission
    public function update($id,Request $request)
    {
        $role=Role::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:3|unique:roles,name,'.$id.',id',
        ]);

        if($validator->passes())
        {
            $role->name=$request->name;
            $role->save();
            if(!empty($request->permission)){
                $role->syncPermissions($request->permission);
            }
            else{
                $role->syncPermissions([]);
            }
            notify()->success('Role updated successfully');
            return redirect()->route('roles.index')->with('success','Role Updated Successfully');
        }
        else
        {
            return redirect()->route('roles.edit',$id)->withInput()->withErrors($validator);
        }
    }
//    This Method Will Destroy Permission
    public function destroy(Request $request)
    {
        $id=$request->id;
        $role= Role::find($id);
        if($role == null){
            session()->flash('error','Role Not Found');
            return response()->json([
                'status'=>false
            ]);
        }
        $role->delete();
        session()->flash('success','Role Deleted successfully');
        return response()->json([
            'status'=>true
        ]);
    }


}
