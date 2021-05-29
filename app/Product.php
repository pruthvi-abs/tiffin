<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements Auditable
{
    //
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    protected $fillable=['categories_id','main_categories_id','p_name','p_code','description','price','image','small_image','is_featured','tiffin_preparation_date','is_visible'];

    public function categories(){
      return $this->belongsTo('App\Category');
    }

}
