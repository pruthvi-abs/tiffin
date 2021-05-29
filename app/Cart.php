<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model implements Auditable
{
  //
  use SoftDeletes;
  use \OwenIt\Auditing\Auditable;
  public $timestamps = true;
  protected $table='carts';
  protected $dates = ['deleted_at'];
  protected $fillable=['products_id','product_name','product_code','price','quantity','user_email','session_id'];


}
