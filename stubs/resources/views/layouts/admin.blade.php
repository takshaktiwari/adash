<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', setting('site_name', 'Adash'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('title', setting('site_name', 'Adash'))" />
    <meta name="keywords" content="@yield('title', setting('site_name', 'Adash'))" />
    <meta name="author" content="Themesbrand" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ setting('favicon', asset('assets/admin/images/favicon.ico')) }}">

    <style>
        :root {
            --primary: {{ setting('theme_colors')['primary']['color'] }};
            --primary2: {{ setting('theme_colors')['primary2']['color'] }};
            --secondary: {{ setting('theme_colors')['secondary']['color'] }};
            --text-color: {{ setting('theme_colors')['text-color']['color'] }};
            --text-color2: {{ setting('theme_colors')['text-color2']['color'] }};
            --text-color3: {{ setting('theme_colors')['text-color3']['color'] }};
            --text-color4: {{ setting('theme_colors')['text-color4']['color'] }};
            --header-bg: {{ setting('theme_colors')['header-bg']['color'] }};
            --footer-bg: {{ setting('theme_colors')['footer-bg']['color'] }};
            --card-bg: {{ setting('theme_colors')['card-bg']['color'] }};
            --card-footer-bg: {{ setting('theme_colors')['card-footer-bg']['color'] }};
        }
    </style>

    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}"
        data-dark="{{ asset('assets/admin/css/bootstrap-dark.min.css') }}" id="bootstrap-style" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/icons.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/select2.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/cropper.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/app.min.css') }}"
        data-dark="{{ asset('assets/admin/css/app-dark.min.css') }}" id="app-style" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}" type="text/css" />

    {{ isset($style) ? $style : '' }}
    @stack('styles')
</head>

<body class="{{ setting('theme_layout') }}" data-sidebar="dark">

    <div id="loader">
        <div class="spinner-border"></div>
    </div>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <x-alertt-alert />
        <x-admin.header />
        <x-admin.sidebar />
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            ©
                            <script>
                                {{ date('Y') }}
                            </script>
                            {{ config('app.name', 'Laravel') }}
                            <span class="d-none d-sm-inline-block">
                                - Crafted with
                                <i class="fas fa-heart text-danger"></i>
                                by
                                <a href="https://github.com/takshaktiwari/" target="_blank"
                                    class="text-success font-weight-bold">
                                    Takshak Tiwari
                                </a>.
                            </span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- for image cropper -->
    <div class="modal" id="cropModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Crop Image</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="image-box" class="image-container"></div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button class="btn btn-outline-info" id="crop-btn" type="button">Crop</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/waves.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/cropper.js') }}"></script>
    <script src="{{ asset('assets/admin/js/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
    <script src="{{ asset('assets/admin/js/script.js') }}"></script>

    {{ isset($script) ? $script : '' }}
    @stack('scripts')
</body>

</html>
