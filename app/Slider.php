<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model implements Auditable
{
    //
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    protected $fillable=['title','description','image','btntitle','btnlink'];

}
