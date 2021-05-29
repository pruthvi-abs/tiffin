<?php

use App\ThemeSetting;
use App\Product;

function customthemesetting(){
  $systemconfig=ThemeSetting::select('tenant_title','tenant_description','tenant_image','tenant_favicon','smtp_from_name','front_email','front_mobile','currency','datetime_format','phone_format','cancel_reasons','catering_cancel_cutoff_time','order_cutoff_time')->where('deleted_at',null)->where('id',1)->first();
  return $systemconfig;
}

function getrootcategoryid($pid){
  $getcatdata=Product::select('main_categories_id')->where('id',$pid)->first();
  if($getcatdata!=null){
    return $getcatdata->main_categories_id;
  }else{
    $cat=0;
    return $cat;
  }
}
