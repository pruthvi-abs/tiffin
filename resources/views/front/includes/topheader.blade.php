<header id="header" class="bg-dark dark pt-2 pb-2">
<div class="container">
<div class="row">
  <div class="col-lg-6 col-md-6">
  <div class="pull-left">
    @php
       $theme_settings_data = DB::select('select * from theme_settings where deleted_at is null and id=1');
    @endphp
      <span class=""><i class="fa fa-phone" aria-hidden="true"></i> {{$theme_settings_data[0]->front_mobile}}</span> |
      <span class=""><i class="fa fa-envelope" aria-hidden="true"></i> {{$theme_settings_data[0]->front_email}}</span>
  </div>
  </div>
  <div class="col-lg-6 col-md-6">
  <div class="pull-right">
    <?php
    /*
    @if (Auth::check())
      {{ Auth::user()->name }}
      show logged in navbar
    @else
      show logged out navbar
    @endif
    */
    ?>
    @guest
      <a href="{{ url('/userlogin') }}">Login  &nbsp;</a>
      <a href="{{ url('/userregister') }}">Register  &nbsp;</a>
    @else
      <a href="#">Welcome, <?php echo Auth::user()->name." | "; ?></a>
      <a href="{{ url('/userdashboard') }}">Dashboard  &nbsp;</a>
      <a href="{{ url('/userlogout') }}">Logout  &nbsp;</a>
    @endguest

  </div>
  </div>
</div>
</div>
</header>
