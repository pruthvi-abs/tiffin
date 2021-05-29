<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements Auditable
{
    use Notifiable;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id','name','email','phone','photo_id','password','is_active','address','city','state','country','pincode','mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
      return $this->belongsTo('App\Role');
    }
    public function country(){
      return $this->belongsTo('App\Country');
    }
    //isAdmin
    public function isActive(){
      if($this->is_active==1){
        return true;
      }
      return false;
    }
    function socialProviders(){
      return $this->hasMany(SocialProvider::class);
    }
    public function photo(){
      return $this->belongsTo('App\Photo');
    }
}
