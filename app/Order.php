<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $table='orders';
    protected $primaryKey='id';
    protected $fillable=['main_categories_id','users_id',
        'users_email','name','address','city','state','pincode','country','mobile','shipping_charges','coupon_code','coupon_amount',
        'order_status','payment_method','grand_total','delivery_date','payer_id','token','amount_received','order_pickup','cancel_notes','cancel_reason'];
}
