<?php

namespace App\Http\Controllers;

use App\Http\Requests\IProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
class ProfileController extends Controller
{
    private $image_path = "storage/profile/";

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

    private function saveProfileImage($image, $imageName){
        ini_set('memory_limit','5096M');
        $file = $image;
        $manager = new ImageManager();

        $image = $manager->make($file);

        $path = $this->image_path.time() . uniqid() . str_replace(' ', '-',$imageName);
        if(!Storage::disk("s3")->exists($this->image_path)) {
            Storage::disk("s3")->makeDirectory($this->image_path, 0775, true);
        }

        Storage::disk("s3")->put($path, $image->stream()->__toString());

        return $path;
    }

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

            if(config("setting.store_img_s3")){
                $path = $this->saveProfileImage($image_base64,$imageName);
            }else{
                file_put_contents($imageFullPath, $image_base64);
            }

            $user = User::findOrFail(auth()->id());
            $user->profile_photo_path = $path;
            $user->save();

            return response()->json(['success' => 'Crop Image Uploaded Successfully']);
        } catch (Exception $e) {
            if(config("app.debug")){
                dd($e->getMessage());
            }else{
                return back()->with('error', config("setting.err_msg"));
        }
        }
    }
}
