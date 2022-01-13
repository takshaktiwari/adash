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
        <link rel="shortcut icon" href="{{ asset('admin/images/favicon.ico') }}">
        <link href="{{ asset('admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin/css/select2.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('admin/css/bootstrap-tagsinput.css') }}">
        <link href="{{ asset('admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

        {{ isset($style) ? $style : '' }}
        {{ isset($style2) ? $style2 : '' }}
    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">

            <x-adash::admin.alert />
            <x-adash::admin.header />
            <x-adash::admin.sidebar />
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
                                    <i class="mdi mdi-heart text-danger"></i> 
                                    by 
                                    <a href="#" target="_blank" class="text-success font-weight-bold">
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
        
        <script src="{{ asset('admin/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('admin/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('admin/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('admin/js/select2.min.js') }}"></script>
        <script src="{{ asset('admin/js/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ asset('admin/js/app.js') }}"></script>

        {{ isset($script) ? $script : '' }}
    </body>
</html>
