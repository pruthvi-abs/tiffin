<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryAddress extends Model implements Auditable
{
    //
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $table='delivery_addresses';
    protected $primaryKey='id';
    protected $fillable=['users_id','users_email','name','address','city','state','pincode','country','mobile'];

}
