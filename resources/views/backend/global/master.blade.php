<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    @include('backend.global.css_support')
    @yield('backend_custom_style')
</head>


<body class="navbar-fixed sidebar-fixed" id="body">
    
    <div class="wrapper">
        @include('backend.layouts.sidebar')
        <div class="page-wrapper">

            <!-- Header -->
            @include('backend.layouts.header')
            <div class="content-wrapper">
                <div class="content">
                    @yield('backend_content')
                </div>
            </div>

            <!-- Footer -->
            @include('backend.layouts.footer')
        </div>
    </div>
    @include('backend.global.js_support')
    @yield('backend_custom_js')
</body>

</html>