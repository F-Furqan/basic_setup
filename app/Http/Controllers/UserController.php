<?php

namespace App\Http\Controllers;

use App\Models\User;
//use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class UserController extends Controller implements HasMiddleware

{
    public static function middleware(): array
    {
        return[
            new Middleware('permission:view users', only: ['index']),
            new Middleware('permission:edit users', only: ['edit']),
            new Middleware('permission:create users', only: ['create']),
            new Middleware('permission:delete users', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
//<td>' . $user->created_at->format("Y-m-d H:i:s").'</td>
    public function index()
    {
        return view('backend.employee.Users.list');
    }
//<a href="" id="' . $user->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editSliderLinkModal"><i class="fa-regular fa-pen-to-square text-warning"></i></a>

    public function fetch() {

        $users = User::all();
        $output = '';
        if ($users->count() > 0) {
            $output .= '<table class="table table-striped table-lg text-center align-middle">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Registration Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($users as $user) {
                $output .= '<tr>
                <td>' . $user->name . '</td>
                <td>' . $user->email . '</td>
                 <td>' . $user->created_at->format("Y-m-d") . '</td>
                <td>
                  <a href="' . route('users.edit', $user->id) . '"  class="text-success mx-1 editIcon"><i class="fa-regular fa-pen-to-square text-warning"></i></a>

                  <a href="" id="' . $user->id . '" class="text-danger mx-1 deleteIcon"><i class="fa-solid fa-trash"></i></a>

                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }

    public function create()
    {
        $roles = Role::orderBy('name','ASC')->get();
        return view('backend.employee.Users.create',[
            'roles'=>$roles
        ])->with('success','User Created Successfully');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:5|same:confirm_password',
            'confirm_password'=>'required'
        ]);
        if($validator->fails())
        {
            return redirect()->route('users.create')->withInput()->withErrors($validator);
        }
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();
        $user->syncRoles($request->role);
        notify()->success('Employee addedd successfully');
        return redirect()->route('users.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles=Role::orderBy('name','ASC')->get();
        $hasRoles=$user->roles->pluck('id');
        return view('backend.employee.users.edit',[
            'user'=>$user,
            'roles'=>$roles,
            'hasRoles'=>$hasRoles
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user= User::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users,email,'.$id.',id'
        ]);
        if($validator->fails())
        {
            return redirect()->route('users.edit',$id)->withInput()->withErrors($validator);
        }
        $user->name=$request->name;
        $user->email=$request->email;
        $user->save();
        $user->syncRoles($request->role);
        return redirect()->route('users.index')->with('success','User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user=User::find($request->id);
        if($user == null)
        {
            session()->flash('error','User not found');
            return response()->json([
                'status'=>false
            ]);
        }

        $user->delete();

        session()->flash('success','User Deleted Successfully');
        return response()->json([
            'status'=>true
        ]);
    }

}
