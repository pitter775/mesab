<style>
    .imgbg{background-image: url("{{ asset('bginterna.png') }}"); background-position: bottom right;
    background-repeat: no-repeat;}    
</style>
<div class="wrapper">


    @include('layouts.navbars.auth')

    <!-- <div class="main-panel" style="background: linear-gradient(to bottom, #f8fafc, #e9eef2);"> -->
    <!-- <div class="main-panel imgbg" style="background: linear-gradient(to bottom, #fff, #e5edf0);"> -->
    <div class="main-panel imgbg">
  
            @include('layouts.navbars.navs.auth')
  
            @yield('content')
            @include('layouts.footer')
      
    </div>
</div>