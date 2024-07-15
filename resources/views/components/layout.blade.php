<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Manajemen Aset | @yield('title', '')</title>
  <meta content="Manajamen Asset DCKTRP" name="description">
  <meta content="" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Favicons -->
  <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  {{-- <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet"> --}}
  {{-- <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet"> --}}
  <link href="{{asset('assets/vendor/DataTables/DataTables-2.0.0/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/DataTables/Responsive-3.0.0/css/responsive.bootstrap5.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">

  <link href="{{asset('assets/vendor/swal2/sweetalert2.min.css')}}" rel="stylesheet">
  <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">




  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jan 09 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  @stack('styles')
</head>

<body>
  @auth
    <x-header></x-header>
    <x-sidebar></x-sidebar>
    <main id="main" class="main">
    <x-breadcrumb></x-breadcrumb>
    {{ $slot }}
  </main>
  <x-footer></x-footer>
  @endauth
  @guest
    {{ $slot }}
  @endguest
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <!-- Vendor JS Files -->
  <script src="{{asset('assets/vendor/jquery/jquery-3.7.1.min.js')}}"></script>
  <script src="{{asset('assets/vendor/jquery/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/DataTables/DataTables-2.0.0/js/dataTables.min.js')}}"></script>
  <script src="{{asset('assets/vendor/DataTables/DataTables-2.0.0/js/dataTables.bootstrap5.min.js')}}"></script>
  <script src="{{asset('assets/vendor/DataTables/Responsive-3.0.0/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('assets/vendor/DataTables/Responsive-3.0.0/js/responsive.dataTables.min.js')}}"></script>
  {{-- <script src="{{asset('assets/vendor/bootstrap/js/dataTables.bootstrap5.min.js')}}"></script> --}}
  {{-- <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script> --}}
  <script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
  {{-- <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script> --}}
  {{-- <script src="{{asset('assets/vendor/quill/quill.min.js')}}"></script> --}}
  {{-- <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script> --}}
  {{-- <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script> --}}
  <script src="{{asset('assets/vendor/swal2/sweetalert2.all.min.js')}}"></script>
  <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>
  @auth
  <script src="{{asset('assets/js/swal.js')}}"></script>
  @endauth
  @stack('scripts')
</body>

</html>

