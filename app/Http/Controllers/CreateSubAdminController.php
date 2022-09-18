<?php

namespace App\Http\Controllers;

use App\Http\Requests\BloggerRequest;
use App\Http\Requests\UpdateBloggerProfile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateSubAdminController extends Controller
{
    public function storeSubAdmin(BloggerRequest $request)
    {
        try{
            if(isSuperAdmin()){
                $data = $request->validated();
                $data['password'] = Hash::make($data['password']);
                $data['email'] = $data['email']."@lyskills.com";
                $data['email_verified_at'] = now();
                $data['is_admin'] = 1;
                User::create($data);
                return redirect()->route('show_sub_admins')->with('status',"Account has been created");
            }
        }
        catch(\Exception $e){
            return back()->with('error','server error');
        }
    }
    public function updateAdmin(UpdateBloggerProfile $request, User $user)
    {
        try{
            if(isSuperAdmin()){
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            $data['email'] = $data['email']."@lyskills.com";
            $user->update($data);
            return redirect()->route('show_sub_admins')->with('status',"Account has been updated");
        }
    }
        catch(\Exception $e){
            return back()->with('error','server error');
        }

    }
}
