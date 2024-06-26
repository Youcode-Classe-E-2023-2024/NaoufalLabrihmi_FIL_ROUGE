<!doctype html>
<html lang="en" class="dark-theme">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="backend/assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="{{URL::to('backend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet" />
    <link href="{{URL::to('backend/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet')}}" />
    <link href="{{URL::to('backend/backend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
    <link href="{{URL::to('backend/assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{URL::to('backend/assets/css/pace.min.css')}}" rel="stylesheet" />
    <script src="{{URL::to('backend/assets/js/pace.min.js')}}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{URL::to('backend/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('backend/assets/css/bootstrap-extended.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{URL::to('backend/assets/css/app.css')}}" rel="stylesheet">
    <link href="{{URL::to('backend/assets/css/icons.css')}}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{URL::to('backend/assets/css/dark-theme.css')}}" />
    <link rel="stylesheet" href="{{URL::to('backend/assets/css/semi-dark.css')}}" />
    <link rel="stylesheet" href="{{URL::to('backend/assets/css/header-colors.css')}}" />
    <!-- toastr css -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <!-- datatable css -->
    <link href="{{URL::to('backend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />

    <title> Admin Dashboard </title>


</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        @include('admin.body.sidebar')
        <!--end sidebar wrapper -->
        <!--start header -->
        @include('admin.body.header')
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            @yield('admin')
        </div>
        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        @include('admin.body.footer')
    </div>
    <!--end wrapper-->


    <!-- search modal -->

    <!-- end search modal -->




    <!--start switcher-->

    <!--end switcher-->
    <!-- Bootstrap JS -->
    <script src="{{URL::to('backend/assets/js/bootstrap.bundle.min.js')}}"></script>
    <!--plugins-->
    <script src="{{URL::to('backend/assets/js/jquery.min.js')}}"></script>
    <script src="{{URL::to('backend/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
    <script src="{{URL::to('backend/assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
    <script src="{{URL::to('backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
    <script src="{{URL::to('backend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{URL::to('backend/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{URL::to('backend/assets/plugins/chartjs/js/chart.js')}}"></script>
    <script src="{{URL::to('backend/assets/js/index.js')}}"></script>
    <!--app JS-->
    <script src="{{URL::to('backend/assets/js/app.js')}}"></script>
    <script>
        new PerfectScrollbar(".app-container")
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{URL::to('backend/assets/js/code.js')}}"></script>
    <script src="{{URL::to('backend/assets/js/validate.min.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type','info') }}"
        switch (type) {
            case 'info':
                toastr.info(" {{ Session::get('message') }} ");
                break;

            case 'success':
                toastr.success(" {{ Session::get('message') }} ");
                break;

            case 'warning':
                toastr.warning(" {{ Session::get('message') }} ");
                break;

            case 'error':
                toastr.error(" {{ Session::get('message') }} ");
                break;
        }
        @endif
    </script>
    <!-- datatable js -->
    <script src="{{URL::to('backend/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::to('backend/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <!-- End datatable js -->
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script>


</body>

</html>