<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\BSON\Binary;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'remember_token',
        'api_token',
        'permissions',
        'roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    /**
     * The attributes that should be cast to na tive types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function get_user_Variables(){
        return[
            'roles' => $this->roles,
            'permissions' => $this->permissions,
            'active' => $this->active,
        ];
    }

    public static function convertRolesToBin($str, $typeObject){
        $bin = base_convert($str,32,2);
        $countObject = 0;
        if ($typeObject == 'role')
            $countObject = count(Role::all());
        elseif ($typeObject == 'permission')
            $countObject = Permission::all();
        if ($countObject == strlen($bin) || $countObject < strlen($bin)){
            return $bin;
        }else{
            for ($i = 0;$i < $countObject - strlen($bin);$i++){
                $bin = "0".$bin;
            }
        }
        return $bin;
    }

    public function hasPermission($indexPermission){
        $roles = $this->convertRolesToBin($this->permissions,'permission');
        return $roles[strlen($roles) - 1 - $indexPermission];
    }

    public function hasRole($indexRole){
        $roles = $this->convertRolesToBin($this->roles,'role');
        return $roles[strlen($roles) - 1 - $indexRole];
    }
}
