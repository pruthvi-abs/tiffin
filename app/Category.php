<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model implements Auditable
{
    //
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    protected $fillable=['main_category_id','parent_id','name','description','url','status'];

    public function main_category(){
      return $this->belongsTo('App\Maincategory');
    }
    public function parent(){
      return $this->belongsTo('App\Category');
    }

}
