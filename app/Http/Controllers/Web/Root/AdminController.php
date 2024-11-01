<?php

namespace App\Http\Controllers\Web\Root;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = (new UserRepository())->query()->whereHas('roles', function($role){
            $role->where('name', 'Admin');
        })->get();

        return view('root.admin.index', compact('admins'));
    }

    public function create()
    {
        return view('root.admin.create');
    }

    public function toggleStatusUpdate(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        return back()->with('success', 'Admin status is updated successful.');
    }

    public function store(UserRequest $request)
    {
       $user = (new UserRepository())->create([
        "first_name" => $request->first_name,
        "last_name" =>  $request->last_name,
        "email" =>  $request->email,
        "gender" =>  $request->gender,
        "mobile" =>  $request->mobile,
        "password" => Hash::make($request->password)
       ]);

       $user->assignRole('Admin');
       $user->givePermissionTo('root');

       return redirect()->route('admin.index')->with('success', 'Admin is created successful.');
    }

    public function edit(User $user)
    {
        return view('root.admin.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        (new UserRepository())->update($user, [
            "first_name" => $request->first_name,
            "last_name" =>  $request->last_name,
            "email" =>  $request->email,
            "gender" =>  $request->gender,
            "mobile" =>  $request->mobile,
            "password" => Hash::make($request->password)
        ]);

        return redirect()->route('admin.index')->with('success', 'Information is updated successful.');
    }

    public function show(User $user)
    {
        $permissions = $user->getPermissionNames()->toArray();
        return view('root.admin.show', compact('user', 'permissions'));
    }

    public function setPermission(Request $request, User $user)
    {
        foreach($request->all() as $key => $permission){
            if($key != '_token'){
                if($permission){
                    $user->givePermissionTo($permission);
                }

                if(!$permission){
                    $expName = explode('_', $key);
                    $permission = implode('.', $expName);
                    $user->revokePermissionTo($permission);
                }
            }
        }

        return back()->with('success', 'Permission setup is successful.');
    }
}
