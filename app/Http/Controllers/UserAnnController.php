<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateNotificationRequest;
use App\Models\InstructorAnn;
use App\Models\User;
use App\Models\UserAnnModel;
use Exception;
use Illuminate\Support\Facades\DB;

class UserAnnController extends Controller
{
    public function viewPayment()
    {
        try {
            $title = "i_payment";
            $users = User::select('name', 'email', 'id')->where('is_instructor', 1)->simplePaginate(15);
            return view('admin.i_payment', ['title' => $title, 'users' => $users]);
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function viewInstructorDetail(User $user)
    {
        try {
            if (isAdmin()) {
                $title = 'view_i_detail';
                return view('admin.monthly_detail', compact('title', 'user'));
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function createInfo()
    {
        try {
            $title = "i_ann";
            return view('admin.i_ann_user', compact('title'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function showInfo()
    {
        try {
            $title = "i_ann";
            $users = DB::table('user_ann_models')->select('message', 'id')->orderByDesc('user_ann_models.message')->get();
            return view('admin.s_ann_user', compact('title', 'users'));
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function postInfo(CreateNotificationRequest $request)
    {
        try {
            $request->validated();
            if (isAdmin()) {
                $message = $request->message;
                if (isset($message) && $message) {
                    $admin = new UserAnnModel();
                    $admin->message = $message;
                    $admin->save();
                    return redirect()->route('s_info_user')->with('status', "your message has saved");
                }
            }
        } catch (Exception $e) {
            return back()->with('error', 'we could not save it. Please try again');
        }
    }

    public function showEdit($i)
    {
        try {
            $title = "i_ann";
            $instructor = DB::table('user_ann_models')->select('message', 'id')->where('id', $i)->get();

            return view('admin.show_edit_ann_user', compact('title', 'instructor'));
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function edit(CreateNotificationRequest $request, UserAnnModel $i)
    {
        try {
            $request->validated();
            $i->message = $request->message;
            $i->save();
            return back()->with('status', 'updated');
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function delete(UserAnnModel $i)
    {
        try {
            if (isAdmin()) {
                $i->delete();
                return response()->json('successful');
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
}
