<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-fluid">
      <a href="/"><img src="{{ asset('img/logo.svg') }}" alt=""></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item"><a class="nav-link" href="{{ url('/floors/map') }}">Floor Plans</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
            Orders
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ url('/orders') }}">View orders</a>
            <a class="dropdown-item" href="{{ url('/orders/search') }}">Create new order</a>
          </div>
      </li>
         
        </ul>
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
        @if (Auth::check() && Auth::user()->hasRole('admin'))
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-success" href="#" data-toggle="dropdown">Admin Actions</a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">User Management</a></li>
          <li><a class="dropdown-item" href="{{ route('orders.index') }}">Orders</a></li>
	        <li><a class="dropdown-item" href="{{ route('rooms.index') }}">Rooms »</a>
		        <ul class="submenu dropdown-menu submenu-left">
		          <li><a class="dropdown-item" href="{{ route('rooms.index') }}">View Rooms</a></li>
		          <li><a class="dropdown-item" href="{{ route('rooms.create') }}">Create new room</a></li>
            </ul>
          </li>
          <li><a class="dropdown-item" href="{{ route('floors.index') }}">Floors »</a>
		        <ul class="submenu dropdown-menu submenu-left">
		          <li><a class="dropdown-item" href="{{ route('floors.index') }}">View Floors</a></li>
		          <li><a class="dropdown-item" href="{{ route('floors.create') }}">Create new floor</a></li>
            </ul>
          </li>
          <li><a class="dropdown-item" href="{{ route('floordrawings.index') }}">Floor Plans »</a>
		        <ul class="submenu dropdown-menu submenu-left">
		          <li><a class="dropdown-item" href="{{ route('floordrawings.index') }}">View Drawings</a></li>
		          <li><a class="dropdown-item" href="{{ route('floordrawings.create') }}">Create new drawing</a></li>
            </ul>
          </li>
        </ul>
      </li>
      @endif
        <!-- <li><a class="btn ml-3" href="{{ url('/reset') }}">Reset App database</a></li> -->

          <!-- Authentication Links -->
          @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
            @else
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('users.show', Auth::user()->id) }}">
                        Profile
                  </a>
                  <a class="dropdown-item" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                </div>
              </li>
          @endguest
        </ul>
      </div>
    </div>
</nav>

@section('javascripts')
<script>
// Prevent closing from click inside dropdown
$(document).on('click', '.dropdown-menu', function (e) {
  e.stopPropagation();
});

// make it as accordion for smaller screens
if ($(window).width() < 992) {
  $('.dropdown-menu a').click(function(e){
    e.preventDefault();
      if($(this).next('.submenu').length){
        $(this).next('.submenu').toggle();
      }
      $('.dropdown').on('hide.bs.dropdown', function () {
     $(this).find('.submenu').hide();
  })
  });
}
</script>