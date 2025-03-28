<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;



class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Billable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'is_blogger',
        'is_admin',
        'is_role',
        "role",
        "language",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function wishLists()
    {
        return $this->hasMany(WishList::class,'user_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === config('settings.roles.admin') || $this->is_admin == 1;
    }

    /**
     * Check if the user has the 'instructor' role.
     */
    public function isInstructor(): bool
    {
        return $this->role === config('settings.roles.instructor') || $this->instructor === 1;
    }

    /**
     * Check if the user has the 'super_admin' role.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === config('settings.roles.super_admin') && $this->is_super_admin === 1;
    }

    /**
     * Check if the user has the 'dev' role.
     */
    public function isDev(): bool
    {
        debug_logs($this->role);
        return $this->role == config('settings.roles.dev');

    }
}
