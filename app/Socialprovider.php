<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Socialprovider extends Model implements Auditable
{
    //
    protected $table = 'socialproviders';
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable=['user_id','provider_id','provider'];

    function user(){
      return $this->belongsTo(User::class);
    }
}
