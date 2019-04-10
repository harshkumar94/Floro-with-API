<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Models\UserActivity;
use App\Models\AuthenticationLog;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','first_name','last_name','address','house_number','postal_code','city','telephone_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function userHistory()
    {
        return $this->MorphMany(UserActivity::class, 'entity')->with('modifiedBy')
            ->orderBy('updated_at', 'desc');
    }

    public function userLastLoginDetails()
    {
        return $this->hasMany(AuthenticationLog::class)->orderBy('created_at', 'desc')->limit(1);
    }
}
