<?php

use App\Models\CourseStatus;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


if (!function_exists('check_input')){
     function check_input($u_input ){
        return htmlspecialchars(trim(stripslashes($u_input)));
    }
}


if (!function_exists('is_xss')){
     function is_xss($u_input ){
        return strip_tags($u_input) !== $u_input;
    }
}

if (!function_exists('reduceCharIfAv')){
     function reduceCharIfAv($u_input,$limit){
        return  strlen($u_input) > $limit ? \Illuminate\Support\Str::limit($u_input,$limit) : $u_input;
    }
}

if (!function_exists('reduceWithStripping')){
     function reduceWithStripping($u_input,$limit){
            $u_input = strip_tags($u_input);
        return  strlen($u_input) > $limit ? \Illuminate\Support\Str::limit($u_input,$limit) : $u_input;
    }
}

if (!function_exists('removeSpace')){
     function removeSpace($input){
         if(is_string ($input)){
             return  trim($input);
         }
         return $input;
    }
}

if (!function_exists('isAdmin')){
     function isAdmin(){
        return Auth::user()->is_admin ?? abort(403);
    }
}

if (!function_exists('allowCourseToAdmin')){
     function allowCourseToAdmin(){
        return Auth::user()->is_admin ? true : false;
    }
}

if (!function_exists('showLessText')){
     function showLessText($text,$len){
         if(strlen($text) > $len){
             return substr($text,$len);
         }
         return $text;
    }
}

if (!function_exists('changeCourseStatus')){
     function changeCourseStatus($course_id,$val,$field_name){
         $c_status = CourseStatus::where('course_id',$course_id)->first();
         if($c_status){
             $c_status->$field_name = $val;
             $c_status->save();
         }
    }
}
if (!function_exists('isSuperAdmin')){

     function isSuperAdmin(){
        return auth()->user()->is_super_admin == 1 ?? abort(403);
    }
}
if (!function_exists('isCurrentUserAdmin')){

     function isCurrentUserAdmin(){
        return auth()->user()->is_admin == 1 ? true : false ;
    }
}

if (!function_exists('setEmailConfigViaAdmin')){

     function setEmailConfigViaAdmin(){
        config(['mail.mailers.host' => getAdminEmail()]);
        config(['mail.mailers.username' => getAdminEmail()]);
        config(['mail.mailers.password' => 'BurraqLyskills']);
        config(['mail.from.address' => getAdminEmail()]);
        config(['mail.from.name' => 'Lyskills']);

    }
}
if (!function_exists('setEmailConfigViaIns')){

     function setEmailConfigViaIns($i_name){
        config(['mail.mailers.host' => getInsEmail()]);
        config(['mail.mailers.username' => getInsEmail()]);
        config(['mail.mailers.password' => 'BurraqLyskills']);
        config(['mail.from.address' => getInsEmail()]);
        config(['mail.from.name' => 'Instructor '.$i_name. ' From Lyskills']);

    }
}
if (!function_exists('getAdminEmail')){

     function getAdminEmail(){
       return  'admin@lyskills.com';
    }

}

if (!function_exists('getInsEmail')){

    function getInsEmail(){
        return  'instructor@lyskills.com';
    }
}

if (!function_exists('setEmailConfigViaStudent')){

     function setEmailConfigViaStudent(){
        config(['mail.mailers.host' => getStudentEmail()]);
        config(['mail.mailers.username' => getStudentEmail()]);
        config(['mail.mailers.password' => 'BurraqLyskillsEngineering65$']);
        config(['mail.from.address' => getStudentEmail()]);
    }
}
if (!function_exists('getStudentEmail')){

     function getStudentEmail(){
       return  'student@lyskills.com';
    }

}

if (!function_exists('setEmailConfigForCourse')){

     function setEmailConfigForCourse(){
        config(['mail.mailers.host' => getCourseEmail()]);
        config(['mail.mailers.username' => getCourseEmail()]);
        config(['mail.mailers.password' => config("setting.no_reply_email_pass")]);
        config(['mail.from.address' => getCourseEmail()]);
        // config(['mail.from.name' => 'Instructor '.$i_name. ' From Lyskills']);

    }
}
if (!function_exists('getCourseEmail')){

     function getCourseEmail(){
       return  'no-reply@lyskills.com';
    }

}

if (!function_exists('isCurrentUserBlogger')){

    function isCurrentUserBlogger(){
       return auth()->user()->is_blogger == 1 ? true : false ;
   }
}

if (!function_exists('dateFormat')){

    function dateFormat($value){
       return Carbon::parse($value)->format('Y-m-d');
   }
}
