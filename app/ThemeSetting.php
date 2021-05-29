<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThemeSetting extends Model implements Auditable
{
    //
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    protected $fillable=['tenant_title','tenant_description','tenant_image','tenant_favicon','currency','order_cutoff_time','pickup_catering_start_time','pickup_catering_end_time','pickup_start_time','pickup_end_time','front_email','front_mobile','datetime_format','phone_format','catering_min_date','smtp_website_name','smtp_server','smtp_port','smtp_email','smtp_email_pass','smtp_from_name','smtp_from_email','smtp_transport_exp','smtp_encryption','cancel_reasons','catering_cancel_cutoff_time'];

}
