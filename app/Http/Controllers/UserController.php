<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UpdateUserReq;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::where('is_super_admin',null)->where('is_admin',null)->where('is_blogger',null)->
            select('id','name','email','is_student','is_instructor','created_at')->
            orderByDesc('created_at')->simplePaginate(20);
        // dd($users);
        $title = 'user_title';
        $order = "ai";
        $search_item = '';
        return view('admin.users',compact('users','title','order','search_item'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function edit(User $user)
    {
       try {
        $title = 'user_title';
        return view('admin.edit-user',compact('user','title'));
       } catch (\Throwable $th) {
           return back();
       }
    }

    public function update(UpdateUserReq $request, User $user)
    {
        try {
            $data = $request->validated();

        if(is_xss($data['name']) || is_xss($data['email'])){
            abort(403);
        }else{
            $user->name = $data['name'];
            $user->email = $data['email'];
            if(array_key_exists('student',$data)){
                $user->is_student = 1;
            }else{
                $user->is_student = 0;
            }
            if(array_key_exists('instructor',$data)){
                $user->is_instructor = 1;
            }else{
                $user->is_instructor = 0;
            }

            $user->save();

            return back()->with('status', 'Updated');
        }
        } catch (\Throwable $th) {
            return back();
        }

    }

    public function delete(User $user)
    {
        try {
            if(Auth::user()->is_admin){
                $user->delete();
                return response()->json([
                    'status' => 'deleted'
                ]);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function sortingUser(Request $request)
    {
       try {
        $order = $request->input('sorting');
        switch ($order) {
            case 'ai':
                $users = User::simplePaginate(10);
                break;
            case 'di':
                $users = User::orderByDesc('id')->simplePaginate(10);
                break;
            case 'an':
                $users = User::orderBy('name')->simplePaginate(10);
                break;
            case 'dn':
                $users = User::orderByDesc('name')->simplePaginate(10);
                break;
            case 'ae':
                $users = User::orderBy('email')->simplePaginate(10);
                break;
            default:
                $users = User::orderByDesc('email')->simplePaginate(10);
                break;
        }

        $title = 'user_title';
        $search_item = '';
        return view('admin.users',compact('users','title','order','search_item'));
       } catch (\Throwable $th) {
           return back();
       }
    }

    public function searchUser(Request $request)
    {
       try {
        $search_item = $request->input('search_item');
        $search_item = removeSpace($search_item);
        $search_item = $search_item;
        $users = User::where('name','like',$search_item.'%')->orWhere('email','like', $search_item.'%')->simplePaginate(10);
        $title = 'user_title';
        $order = "ai";

        return view('admin.users',compact('users','title','order','search_item'));
       } catch (\Throwable $th) {
           return back();
       }

    }
}
