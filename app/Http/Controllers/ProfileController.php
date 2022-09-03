<?php

namespace App\Http\Controllers;

use App\Http\Requests\IProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile()
    {
        try {
            $title = "profile";
            $user = User::select('name', 'id')->findOrFail(auth()->id());

            $profile = $user->profile;
            return view('instructor.profile', compact('title', 'user', 'profile'));
        } catch (\Throwable $th) {
            return back();
        }
    }
    /**
     * save instructor profile
     * @return user profile
     * @param Request 
     */

    public function saveProfile(IProfileRequest $request)
    {

        try {
            $request->validated();
            $user = User::findOrFail(auth()->id());
            $profile_detail = $request->except(['name', '_token']);

            if ($user) {
                $user->name = $request->name;
                $user->save();
            } else {
                abort(403);
            }

            $profile = $user->profile;
            if ($profile) {
                $profile->update($profile_detail);
            } else {
                $profile_detail['user_id'] = auth()->id();
                Profile::create($profile_detail);
            }

            return back()->with('status', 'profile has updated');
        } catch (Exception $e) {
            return back()->with('error', 'this action cannot be performed now. plz try again');
        }
    }

    public function uploadCropImage(Request $request)
    {
        try {
            $path = 'storage/img/';
            $folderPath = public_path('storage/img/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath);
            }

            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $imageName = uniqid() . '.png';

            $imageFullPath = $folderPath . $imageName;
            $path = $path . $imageName;

            file_put_contents($imageFullPath, $image_base64);


            $user = User::findOrFail(auth()->id());
            $user->profile_photo_path = $path;
            $user->save();

            return response()->json(['success' => 'Crop Image Uploaded Successfully']);
        } catch (Exception $e) {
            return back()->with('error', 'this action cannot be performed now.plz try again. ' . $e->getMessage());
        }
    }
}
