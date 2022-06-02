<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>@yield('title', config('app.name', 'Laravel'))</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="@yield('title', config('app.name', 'Laravel'))"  />
        <meta name="keywords" content="@yield('title', config('app.name', 'Laravel'))"  />
        <meta name="author" content="Themesbrand"  />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}" data-dark="{{ asset('assets/admin/css/bootstrap-dark.min.css') }}" id="bootstrap-style" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/admin/css/icons.min.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/admin/css/select2.min.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-tagsinput.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/cropper.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/app.min.css') }}" data-dark="{{ asset('assets/admin/css/app-dark.min.css') }}" id="app-style"  type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}" type="text/css" />

        {{ isset($style) ? $style : '' }}
        @stack('styles')
    </head>

    <body data-sidebar="dark">

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
                                © <script>{{ date('Y') }}</script>
                                {{ config('app.name', 'Laravel') }}
                                <span class="d-none d-sm-inline-block">
                                     - Crafted with
                                    <i class="fas fa-heart text-danger"></i>
                                    by
                                    <a href="https://github.com/takshaktiwari/" target="_blank" class="text-success font-weight-bold">
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
