<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin-layout.head')
    @include('admin-layout.global_style')
    @stack('styles')
</head>

<body>
    <div class="container-scroller">
        @include('admin-layout.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('admin-layout.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header m-2">
                        @yield('title')
                        @if (isset($breadcrumbs))
                            @include('admin-layout.breadcrumb', ['breadcrumbs' => $breadcrumbs])
                        @endif
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @include('admin-layout.footer')
    @include('admin-layout.global_js')
    @stack('scripts')
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/todolist.js"></script>
    <script src="/assets/js/jquery.cookie.js"></script>
</body>

</html>