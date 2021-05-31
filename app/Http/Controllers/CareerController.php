<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index(){
        $data['pagetitle']="Career";
        return view('front.career.index')->with($data);
    }

    public function getcareerinfo(){
        
    }
}
