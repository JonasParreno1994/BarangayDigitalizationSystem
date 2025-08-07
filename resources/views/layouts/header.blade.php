<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', '') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('design/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('design/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('design/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('design/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('design/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/design/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/design/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

     <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('design/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('design/plugins/toastr/toastr.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav ml-auto">
               
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        {{ Auth::user()->name }} <i class="far fa-user"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">

                        <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
                        <a href="{{ route('auth.register') }}" class="dropdown-item">Register User</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Log Out</button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">

                    </div>
                    <div class="info">
                        <a href="#" class="d-block"> </a>
                    </div>
                </div>
                @include('components.sidebar')
            </div>
        </aside>
        <div class="content-wrapper">
            <main>
                @yield('content')
            </main>
        </div>
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">ONE-BYTE SOFTWARE</div>
            <strong>Copyright &copy; 2025 <a href="https://adminlte.io">TEAM MISO-HINOBA-AN</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('design/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('design/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('design/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('design/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('design/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('design/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('design/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('design/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('design/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('design/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('design/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/design/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/design/plugins/select2/js/select2.full.min.js') }}"></script>


    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,

            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    
    
</body>

</html>
