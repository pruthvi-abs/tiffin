<div class="wui-side-menu open pinned" data-wui-theme="dark">
  <ul class="wui-side-menu-items">
    <li><a href="{{ url('/userdashboard') }}" class="wui-side-menu-item @php if($userleftmenu=='userdashboard'){ echo 'active'; } @endphp"><span class="box-title">Dashboard</span></a></li>
    <li><a href="{{ url('/myaccount') }}" class="wui-side-menu-item @php if($userleftmenu=='account'){ echo 'active'; } @endphp"><span class="box-title">My Account</span></a></li>
    <li><a href="{{ url('/userupdatepassword') }}" class="wui-side-menu-item  @php if($userleftmenu=='changepassword'){ echo 'active'; } @endphp"><span class="box-title">Change Password</span></a></li>
    <li><a href="{{ url('/myorder') }}" class="wui-side-menu-item  @php if($userleftmenu=='myorder'){ echo 'active'; } @endphp"><span class="box-title">Orders</span></a></li>
  </ul>
</div>
