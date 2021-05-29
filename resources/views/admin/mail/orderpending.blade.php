@extends('admin.layout.mail')
@section('content')
@php
  $theme_data = App\ThemeSetting::select('tenant_image','front_email','front_mobile','tenant_title','tenant_favicon')->where('deleted_at',null)->where('id',1)->first();
@endphp
<table border="0" width="600" cellspacing="0" cellpadding="0" align="center">
  <tbody>
    <tr>
      <td align="left" valign="top">
        <div style="text-align: center;"><center><img style="margin-top: 0px; border-radius: 5px; margin-bottom: 10px;" src="{{asset('public/websitelogo')}}/{{ $theme_data->tenant_image }}" alt="" width="200"  /></center></div>
      </td>
    </tr>
    <tr>
      <td style="font-family: Arial,Helvetica,sans-serif; font-size: 13px; padding: 10px; border-width: 2px 2px 1px; border-style: solid; border-color: #1c2c4f; color: #1c2c4f; background-color: #fff;" align="center" valign="top" bgcolor="#fff">
        <table style="margin-top: 10px;" border="0" width="100%" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td style="font-family: Arial,Helvetica,sans-serif; font-size: 13px; color: #000;" align="left" valign="top">
                <div style="font-size: 15px; text-align: left;"><br />
                  <p>Dear {{ $username }},</p>
                  <p>Thank you for your order from Prasadam.  If you have questions about your order, you can email us at {{ $theme_data->front_email }}.
                  <?php
                  $total_price=0;
                  $contents='';
                  $contents.='<style>';
                  $contents.='h1{color: navy;font-family: times;font-size: 24px;text-decoration: underline;}';
                  $contents.='table tr td{font-size: large;}';
                  $contents.='table tr th{font-size: large;}';
                  $contents.='h3{font-size: x-large;}';
                  $contents.='p{font-size: large;}';
                  $contents.='</style>';

                  $contents.='<div class="table-responsive">';
                  $contents.='<table id="" width="100%" cellpadding="2" cellspacing="2" class="table table-bordered">';
                  $contents.='<tr>';
                  $contents.='<td style="text-align:left;" colspan="6">';
                  $contents.='<p><strong>Confirmation</strong> : #'.$order_id;
                  $contents.='<br><strong>Payment Status</strong> : '.$payment_status;
                  /*if($payment_method=="Paypal"){
                   $contents.='<br><strong>Payment Mode</strong> : '.$order_data->payment_method.' ('.$order_data->payer_id.')'.'</p>';
           		    }else{
                   $contents.='<br><strong>Payment Mode</strong> : '.$order_data->payment_method.'</p>';
                 }*/
                  $contents.='</td>';
                  $contents.='</tr>';
                  $contents.='</table>';
                  $contents.='</div>';

                  $contents.='<div class="table-responsive">';
                  $contents.='<table id="" border="1" width="100%" cellpadding="2" style="border-color:#ccc;" cellspacing="2" class="table table-bordered">';
                  //$contents.='<thead>';
                  $contents.='<tr>';
                  $contents.='<td>Sr No</td>';
                  $contents.='<td colspan="2">Name</td>';
                  $contents.='<td>Price</td>';
                  $contents.='<td>Quantity</td>';
                  $contents.='<td>Total</td>';
                  $contents.='</tr>';
                  //$contents.='</thead>';
                  //$contents.='<tbody>';
                  $i=1;
                  foreach($order_data as $data){
                    $total_price = $total_price + ($data['qty']*$data['price']);
                  $contents.='<tr>';
                    $contents.='<td>'.$i.'</td>';
                    $contents.='<td colspan="2">'.$data['name'].'</td>';
                    $contents.='<td>'.$customthemesetting->currency.$data['price'].'</td>';
                    $contents.='<td>'.$data['qty'].'</td>';
                    $contents.='<td>'.$customthemesetting->currency.$data['qty']*$data['price'].'</td>';
                    $contents.='</tr>';
                    $i++;
                  }

                  $contents.='<tr>';
                  $contents.='<td colspan="4">&nbsp;</td>';
                  $contents.='<td colspan="2">';
                  $contents.='<table id="" border="1" width="100%" cellpadding="2" style="border-color:#ccc;" cellspacing="2" class="table table-bordered">';
                          $contents.='<tr>';
                          $contents.='<td>Cart Sub Total</td>';
                          $contents.='<td>'.$customthemesetting->currency.$total_price.'</td>';
                          $contents.='</tr>';
                          /*
                          if($order_data->coupon_amount > 0){
                                $contents.='<tr>';
                                    $contents.='<td>Coupon Discount</td>';
                                    $contents.='<td><span>'.$customthemesetting->currency.$order_data->coupon_amount.'</span></td>';
                                $contents.='</tr>';
                                $contents.='<tr>';
                                    $contents.='<td>Total</td>';
                                    $contents.='<td><span>'.$customthemesetting->currency.$total_price.'</span></td>';
                                $contents.='</tr>';
                          }else{
                          */
                                $contents.='<tr>';
                                    $contents.='<td>Total</td>';
                                    $contents.='<td><span>'.$customthemesetting->currency.$total_price.'</span></td>';
                                $contents.='</tr>';
                          //}
                          $contents.='</table>';
                      $contents.='</td>';
                  $contents.='</tr>';

                  //$contents.='</tbody>';
                  $contents.='</table>';
                  echo $contents;
                  ?>
                  <p>Thanks</p>
                  <p>{{$customthemesetting->smtp_from_name}}</p>
                </div>
              <div style="font-size: 15px; text-align: left;">&nbsp;</div>
            </td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
  <tr style="width: 100%;">
    <td style="background-color:#1c2c4f; border-bottom: 3px solid #1c2c4f; border-left: 2px solid #1c2c4f; border-right: 2px solid #1c2c4f;" align="left" valign="top" bgcolor="#222">
      <table style="width: 100.205%; height: 90px;" border="0" width="100%" cellspacing="0" cellpadding="15">
        <tbody>
          <tr style="width: 100%;">
            <td style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-size: 14px; padding: 10px; width: 27.1387%; color: #ffffff; border-bottom: 1px solid #ffffff; font-weight: bold; border-right: 1px solid #ffffff;">Reach Us</td>
            <td style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-size: 14px; padding: 10px; width: 27.1387%; color: #ffffff; border-bottom: 1px solid #ffffff; font-weight: bold;" align="left" valign="top">Contact Us</td>
          </tr>
          <tr style="width: 100%;">
            <td style="color: #ffffff; font-family: Arial, Helvetica, sans-serif; text-align: center; padding: 0px 0px 10px; font-size: 14px; width: 27.1387%; border-right: 1px solid #ffffff;"><a style="color: #ffffff; text-decoration: none;" href="#"><strong style="color: #ffffff; text-decoration: none;">{{ $theme_data->front_email }}</strong></a></td>
            <td style="color: #ffffff; font-family: Arial, Helvetica, sans-serif; text-align: center; padding: 0px 0px 10px; font-size: 14px; width: 27.1387%;" align="left" valign="top"><a style="color: #ffffff; text-decoration: none;" href="#" target="_blank" rel="noopener"> <strong style="color: #ffffff; text-decoration: none;">{{ $theme_data->front_mobile }}</strong> </a></td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
</tbody>
</table>

@endsection
