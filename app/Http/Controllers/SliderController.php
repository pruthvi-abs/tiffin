<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Auth;
use DataTables;
use Validator;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;
use Config;
use Intervention\Image\Facades\Image;

class SliderController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['webpage']='SliderManagement';
        $data['action']='Slider';
        $data['menu']='master';
        return view('admin.frontslider.index')->with($data);
    }
    function getFrontslider()
    {
      $customthemesetting = customthemesetting();
        $user = Auth::user();
        $sliders=Slider::select('id','image','title','created_at')->get();
        $slider_data=array();
        $i=1;
        foreach($sliders as $slider){
          $slider_data[$i]['sr_no']=$i;
          $slider_data[$i]['id']=$slider->id;
          $slider_data[$i]['title']=$slider->title;
          $base_url = url('/');
          if($slider->image==""){
            $pro_image = $base_url."/public/productplaceholder.png";
            $slider_data[$i]['image'] = $pro_image;
          }else{
              $slider_data[$i]['image']=$slider->image;
          }
          $slider_data[$i]['created_at']=Carbon::parse($slider->created_at)->format($customthemesetting->datetime_format);
          $i++;
        }
        return Datatables::of($slider_data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data['webpage']='SliderManagement';
      $data['action']='Slider -> Create Slider';
      $data['menu']='master';
      return view('admin.frontslider.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'title' => 'required',
        'description' => 'required',
        'btntitle' => 'required',
        'btnlink' => 'required',
      ]);
      $slider = new Slider;
      $slider->title = $request->title;
      $slider->description = $request->description;
      $slider->btntitle = $request->btntitle;
      $slider->btnlink = $request->btnlink;

      if($file=$request->file('image')){
        $sliderimage = time().$file->getClientOriginalName();
        $location='public/frontend/images/slider/';
        $file->move($location,$sliderimage);

        $copy_file_path = "/home/neoinventions/public_html/dailytiffin/public/frontend/images/slider/".$sliderimage;
        $past_file_path = "/home/neoinventions/public_html/dailytiffin/public/frontend/images/slider/small/".$sliderimage;
        copy($copy_file_path,$past_file_path);
        // crop image
        $img_crop = Image::make(public_path('frontend/images/slider/small/'.$sliderimage))->fit('1920','600');
        $img_crop->save();

        $slider->image = $location."small/".$sliderimage;
      }else{
        $slider->image = "";
      }

      $slider->save();

      return redirect('frontslider')->with('success','Information added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data['frontslider']=Slider::findOrFail($id);
        $data['webpage']='SliderManagement';
        $data['action']='Slider -> Edit Slider';
        $data['menu']='master';
        return view('admin.frontslider.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request, [
        'title' => 'required',
        'description' => 'required',
        'btntitle' => 'required',
        'btnlink' => 'required',
      ]);

        $slider=Slider::findOrFail($id);
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->btntitle = $request->btntitle;
        $slider->btnlink = $request->btnlink;

        if($file=$request->file('image')){
          $sliderimage = time().$file->getClientOriginalName();
          $location='public/frontend/images/slider/';
          $file->move($location,$sliderimage);

          $copy_file_path = "/home/neoinventions/public_html/dailytiffin/public/frontend/images/slider/".$sliderimage;
          $past_file_path = "/home/neoinventions/public_html/dailytiffin/public/frontend/images/slider/small/".$sliderimage;
          copy($copy_file_path,$past_file_path);
          // crop image
          $img_crop = Image::make(public_path('frontend/images/slider/small/'.$sliderimage))->fit('1920','600');
          $img_crop->save();

          $slider->image = $location."small/".$sliderimage;
        }
        $slider->save();
      return redirect('frontslider')->with('success','Information changed successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Slider=Slider::findOrFail($id)->delete();
        $error=0;
        return $error;
    }
}
