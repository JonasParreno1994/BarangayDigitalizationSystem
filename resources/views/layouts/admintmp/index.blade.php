<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>{{ env('APP_NAME', 'Laravel') }} </title>
  <meta name="description" content="">
  <meta name="keywords" content="">

@vite(['resources/css/app.css', 'resources/js/app.js'])

<link href="{{ asset('/1.png') }}" rel="icon">
<link href="{{ asset('/1.png') }}" rel="apple-touch-icon">
<link href="{{ asset('css2.css') }}" rel="stylesheet">


<link href="{{ asset('/Impact/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/Impact/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('/Impact/assets/vendor/aos/aos.css') }}" rel="stylesheet">
<link href="{{ asset('/Impact/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
<link href="{{ asset('/Impact/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">


<link href="{{ asset('Impact/assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header fixed-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="">jonaspareno12345@gmail.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>09850054226</span></i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            <a href="{{ route('login') }}" class="login"><i class="bi bi-box-arrow-in-right"></i></a>
        </div>
      </div>
    </div> 

    <div class="branding d-flex align-items-cente">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="" class="logo d-flex align-items-center">
            <img src="{{ asset('/1.png') }}" alt="" class="logo-image">
            <h1 class="sitename" style="font-size: 24px;">iBarangay</h1>
          <span></span>
        </a>

        @include('layouts.admintmp.nav')

      </div>

    </div>

  </header>

  <main>
    @yield('content')
  </main>



  @include('layouts.admintmp.footer')

  
