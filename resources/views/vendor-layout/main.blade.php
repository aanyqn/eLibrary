<!DOCTYPE html>
<html lang="en">
    <head>
        @include('vendor-layout.head')
        @include('vendor-layout.global_style')
        @stack('styles')
    </head>
    <body>
        <div class="container-scroller">
            @include('vendor-layout.navbar')
            <div class="container-fluid page-body-wrapper">
                @include('vendor-layout.sidebar')
                <div class="main-panel">
                    <div class="content-wrapper">
                    <div class="page-header m-2">
                        @yield('title')
                        @if (isset($breadcrumbs))
                            @include('vendor-layout.breadcrumb', ['breadcrumbs' => $breadcrumbs])
                        @endif
                    </div>
                    @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @include('vendor-layout.footer')
        @include('vendor-layout.global_js')
        @stack('scripts')
    </body>
</html>



