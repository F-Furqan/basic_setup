<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return[
            new Middleware('permission:view permission', only: ['index']),
            new Middleware('permission:edit permissions', only: ['edit']),
            new Middleware('permission:create permissions', only: ['create']),
            new Middleware('permission:delete permissions', only: ['destroy']),

        ];
    }

//    This Method Will Show Permission Page
    public function index()
    {
        /*$permissions=Permission::orderBy('created_at','DESC')->paginate(10);*/
        return view('backend.employee.Permission.list');
        /*return view('Permission.list',[
            'permissions'=>$permissions
        ]);*/


    }
    public function fetch() {

        $permissions=Permission::all();
        $output = '';
        if ($permissions->count() > 0) {
            $output .= '<table class="table table-striped table-lg text-center align-middle">
            <thead>
              <tr>
                <th>Name</th>
                <th>Created at</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($permissions as $permission) {
                $output .= '<tr>
                <td>' . $permission->name . '</td>
                 <td>' . $permission->created_at->format("Y-m-d") . '</td>
                <td>
                  <a href="' . route('permissions.edit', $permission->id) . '"  class="text-success mx-1 editIcon"><i class="fa-regular fa-pen-to-square text-warning"></i></a>

                  <a href="" id="' . $permission->id . '" class="text-danger mx-1 deleteIcon"><i class="fa-solid fa-trash"></i></a>

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
        return view('backend.employee.permission.create');
    }
//    This Method Will Store Permission
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|unique:permissions|min:3',
        ]);

        if($validator->passes())
        {
            Permission::create([
                'name'=>$request->name
            ]);
            notify()->success('Permission addedd successfully');
            return redirect()->route('permissions.index');
        }
        else
        {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

//    This Method Will find updated Record
    public function edit($id)
    {

        $permission=Permission::findOrFail($id);
        return view('backend.employee.Permission.edit',[
            'permission'=>$permission
        ]);

    }
//    This Method Will update Permission
    public function update($id,Request $request)
    {
        $permission=Permission::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:3|unique:permissions,name,'.$id.',id',
        ]);

        if($validator->passes())
        {
            $permission->name=$request->name;
            $permission->save();
            notify()->success('Permission updated successfully');
            return redirect()->route('permissions.index');
        }
        else
        {
            return redirect()->route('permissions.edit',$id)->withInput()->withErrors($validator);
        }
    }
//    This Method Will Destroy Permission
    public function destroy(Request $request)
    {

        $id=$request->id;
        $permission=Permission::find($id);
        if($permission == null)
        {
            session()->flash('error','Permission not found');
            return response()->json([
                'status'=>false
            ]);
        }

        $permission->delete();

        session()->flash('success','Permission Deleted Successfully');
        return response()->json([
            'status'=>true
        ]);

    }

}
