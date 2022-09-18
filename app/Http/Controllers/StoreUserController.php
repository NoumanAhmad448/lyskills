<?php

namespace App\Http\Controllers;

use App\Models\FetchUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreUserController extends Controller
{
    public function storeUser()
    {
        try{
            $fetched_users = FetchUser::whereNotNull('email')->select('name','email','updated_at',DB::raw('now() as created_at'), 
                DB::raw('now() as email_verified_at'),
                DB::raw('IF(true,"$2y$10$MH6RzLwd/G5FShnL4Gy8heOVK1fqBLpCbvt1UtYC5Q0YiAInhF7ZO","") as password'),
                DB::raw('IF(true,1,"") as is_student')
                )->get()->toArray();
        foreach ($fetched_users as $user) {
            $User12 = User::where('email', $user['email'])->first();
            if(!$User12){
                User::updateOrCreate($user);
            }
        }
        }
        catch(\Throwable $e){
            dd($e->getMessage());
        }
    }
}
