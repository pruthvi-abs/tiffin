
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
                  <p>Your order id #{{ $order_id }} has been accepted.</p>
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
