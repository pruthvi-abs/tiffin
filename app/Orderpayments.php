<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orderpayments extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $table='orderpayments';
    protected $primaryKey='id';
    protected $fillable=['order_id','payment_type','account_type','payment_details','payment_amount','payment_date','notes','payment_status'];
}
