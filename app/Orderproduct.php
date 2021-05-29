<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orderproduct extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $table='orderproducts';
    protected $primaryKey='id';
    protected $fillable=['order_id','p_id','p_code','p_name','p_price','p_qty'];
        
}
