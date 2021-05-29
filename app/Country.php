<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model implements Auditable
{
        //
        use SoftDeletes;
        use \OwenIt\Auditing\Auditable;
        public $timestamps = true;
        protected $dates = ['deleted_at'];

        protected $fillable=['country_code','country_name'];
        public function setNameAttribute($value){
         	 $this->attributes['country_name'] = ucwords($value);
        }

}
