<nav class="navbar navbar-custom navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/"><img src="{{ asset('img/logo.svg') }}" alt=""></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
  <!-- Left Side Of Navbar -->
    <ul class="navbar-nav mr-auto">
    @if ($floorsDrawingsCount > 0)
      <li class="nav-item active">
        <a class="nav-link" href="{{ url('/floors/map') }}">Floor Plans<span class="sr-only">(current)</span></a>
      </li>
    @endif

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="ordersDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Orders
        </a>
        <ul class="dropdown-menu" aria-labelledby="ordersDropdownMenuLink">
          <li><a class="dropdown-item" href="{{ route('orders.index') }}">View orders</a></li>
          <li><a class="dropdown-item" href="{{ route('orders.search') }}">Create new order</a></li>
          <li><a class="dropdown-item" href="{{ route('orders.stats') }}">View Orders Data</a></li>
        </ul>
      </li>
    </ul>

  <!-- Right Side Of Navbar -->
    <!-- Admin navbar, show if admin is auth'd -->
    @if (Auth::check() && Auth::user()->hasRole('admin'))
    <ul class="navbar-nav">
      <li class="nav-item dropdown dropdown-menu-right">
        <a class="nav-link dropdown-toggle text-success" href="#" id="adminDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Admin Actions
        </a>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="adminDropdownMenuLink">
          <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">User Management</a></li>
          <li><a class="dropdown-item" href="{{ route('orders.all') }}">All Orders</a></li>

          <li class="dropdown-submenu">
            <a class="dropdown-item dropdown-toggle" href="#">Floors</a>
            <ul class="dropdown-menu submenu-left">
              <li><a class="dropdown-item" href="{{ route('floors.index') }}">View Floors</a></li>
              <li><a class="dropdown-item" href="{{ route('floors.create') }}">Create new floor</a></li>
            </ul>
          </li>

          <li class="dropdown-submenu">
            <a class="dropdown-item dropdown-toggle" href="#">Rooms</a>
            <ul class="dropdown-menu submenu-left">
              <li><a class="dropdown-item" href="{{ route('rooms.index') }}">View Rooms</a></li>
              <li><a class="dropdown-item" href="{{ route('rooms.create') }}">Create new room</a></li>
            </ul>
          </li>

          <li class="dropdown-submenu">
            <a class="dropdown-item dropdown-toggle" href="#">Floor Plans</a>
            <ul class="dropdown-menu submenu-left">
              <li><a class="dropdown-item" href="{{ route('floordrawings.index') }}">View Drawings</a></li>
              <li><a class="dropdown-item" href="{{ route('floordrawings.create') }}">Create new drawing</a></li>
            </ul>
          </li>

        </ul>
      </li>
    </ul>
    @endif

    <ul class="navbar-nav">
      <!-- guest nav-items, show if no user is auth'd -->
      @guest
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
      </li>
      @if (Route::has('register'))
      <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
      </li>
      @endif
      @endguest
      <!-- user nav-items, show if user is auth'd -->
      @auth
      <li class="nav-item dropdown dropdown-menu-right">
        <a class="nav-link dropdown-toggle" href="#" id="profileDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdownMenuLink">
          <li><a class="dropdown-item" href="{{ route('users.show', Auth::user()->id) }}">Profile</a></li>
          <li>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
          </li>
        </ul>
      </li>
      @endauth
    </ul>

  </div>
</nav>