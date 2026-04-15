<!-- partial:partials/_sidebar.html -->
@php
$menus = [
    ['route' => 'vendor.dashboard', 'label' => 'Dashboard', 'icon' => 'mdi-home','group' => 'main'],
    ['route' => 'vendor.menu', 'label' => 'Menu', 'icon' => 'mdi-book','group' => 'menu'],
    ['route' => 'vendor.pesanan', 'label' => 'Pesanan', 'icon' => 'mdi-receipt','group' => 'pesanan'],
];
@endphp
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="/assets/images/faces/face1.jpg" alt="profile" />
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">{{ auth()->user()->name }}</span>
                  <span class="text-secondary text-small">
                    {{ auth()->user()->roles->first()?->name }}
                  </span>
                </div>
              </a>
            </li>
            @foreach($menus as $menu)
            @php
            $isActive = request()->routeIs($menu['route']);
            @endphp
            <li class="nav-item">
              <a class="nav-link {{ $isActive ? 'color-purple' : '' }}" href="{{ route($menu['route']) }}">
                <span class="menu-title">{{ $menu['label'] }}</span>
                <i class="mdi {{ $menu['icon'] }} menu-icon"></i>
              </a>
            </li>
            @endforeach
            <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}">
                <span class="menu-title">Logout</span>
                <i class="mdi mdi-exit-to-app menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->