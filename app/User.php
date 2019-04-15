<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

use Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','postal_code','user_name','email', 'password',
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

    /**
     * Check Roles admin here 
     *
     * @var array
     */
    public function isAdmin(){
        $role = Role::join('role_user','roles.id','=','role_user.role_id')
                      ->where('user_id',Auth::user()->id)
                      ->first();
        return $role->name == 'admin' ? true : false;   
    }

    /**
     * Check Roles for Host here 
     *
     * @var array
     */
    public function isHost(){
        $role = Role::join('role_user','roles.id','=','role_user.role_id')
                      ->where('user_id',Auth::user()->id)
                      ->first();
        return $role->name == 'host' ? true : false;   
    }

    /**
     * Check Roles for Shopper here 
     *
     * @var array
     */
    public function isShopper(){
        $role = Role::join('role_user','roles.id','=','role_user.role_id')
                      ->where('user_id',Auth::user()->id)
                      ->first();
        return $role->name == 'shopper' ? true : false;   
    }

    public function getRole()
    {
        // return $this->belongsToMany('App\Role', 'role_user');
        return $this->hasOneThrough('App\Role', 'App\Models\UserRoleRelation', 'user_id', 'id', 'id', 'role_id');
    }
}
