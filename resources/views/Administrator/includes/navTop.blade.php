<!-- Topnav -->
<nav id="sidenav-main"
  class="navbar navbar-top navbar-expand navbar-dark bg-{{config("app.theme_color.name")}} border-bottom"
  data-theme-bg-color="{{config("app.theme_color.name")}}">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Search form -->
      <form class="d-none navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
        <div class="form-group mb-0">
          <div class="input-group input-group-alternative input-group-merge">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input class="form-control" placeholder="{{Translator::phrase("search")}}" type="text">
          </div>
        </div>
        <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main"
          aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </form>
      <!-- Navbar links -->
      <ul class="navbar-nav align-items-center ml-md-auto">
        <li class="nav-item d-xl-none">
          <!-- Sidenav toggler -->
          <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </li>
        <li class="nav-item d-sm-none">
          <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
            <i class="ni ni-zoom-split-in"></i>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link" data-toggle="dropdown" id="navbarDropdownMenuLink2">
            <span><img width="26" src="{{config('app.languages.'.app()->getLocale().".image")}}" /></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink2">
            @foreach (config('app.languages') as $lang)
            <li>
              <a class="dropdown-item" href="{{$lang["action"]["set"]}}">
                <span><img width="26" src="{{ $lang["image"]}}" /></span>
                <span>{{ Translator::phrase($lang["code_name"],"en")}}</span>
              </a>
            </li>
            @endforeach
          </ul>
        </li>


      </ul>

      <ul class="navbar-nav align-items-center ml-auto ml-md-0">
        <li class="nav-item dropdown">
          <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img data-alt="{{Auth::user()->name}}" data-src="{{Auth::user()->profile()}}">
              </span>
              <div class="media-body ml-2 d-none d-lg-block">
                <span class="mb-0 text-sm  font-weight-bold">{{Auth::user()->name}}</span>
              </div>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-right">

            <a href="{{url(Auth::user()->role()."/profile")}}" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span> {{ Translator::phrase('my_profile') }}</span>
            </a>
            <a href="{{url(Auth::user()->role()."/dashboard")}}" class="dropdown-item">
              <i class="fas fa-tv"></i>
              <span> {{ Translator::phrase('dashboard') }}</span>
            </a>

            <div class="dropdown-divider"></div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
              <i class="ni ni-user-run"></i>
              {{ Translator::phrase('logout') }}
            </a>
          </div>
        </li>
      </ul>

    </div>
  </div>
</nav>
