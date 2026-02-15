<!DOCTYPE html>
<html lang="en">
    <head>
        @include('general-layout.head')
        @include('general-layout.global_style')
        @yield('styles')
    </head>
    <body>
        <div class="container-scroller">
            @include('general-layout.navbar')
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
        @include('general-layout.global_js')
        @yield('scripts')
    </body>
</html>



