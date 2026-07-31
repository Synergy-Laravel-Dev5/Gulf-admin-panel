<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | GULF HAJJ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build , CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/Edupilot.png') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <!-- Icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@700;800&display=swap" rel="stylesheet">

    <!-- Summernote Lite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

</head>

<!-- body start -->

<body data-menu-color="light" data-sidebar="default">
    <div id="app-layout">

        @include('layout.header')

        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

        @yield('content')

        @include('layout.footer')

        <!-- Baaki libraries -->
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
        <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>

        <!-- Apexcharts JS -->
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- for basic area chart -->
        <script src="{{ asset('assets/apexcharts.com/samples/assets/stock-prices.js') }}"></script>

        <!-- Widgets Init Js -->
        <script src="{{ asset('assets/js/pages/crm-dashboard.init.js') }}"></script>

        <!-- App js-->
        <script src="{{ asset('assets/js/app.js') }}"></script>

        <!-- Datatable Demo App Js -->
        <script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof feather !== "undefined") {
                    feather.replace();
                }

                if (typeof $ !== "undefined" && $.fn.summernote) {
                    $('.summernote').summernote({
                        placeholder: 'Type content here...',
                        tabsize: 2,
                        height: 150,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link']],
                            ['view', ['fullscreen', 'codeview']]
                        ]
                    });
                }
            });
        </script>
    </div>
</body>

</html>
