<!-- Topnav -->
<nav class="navbar navbar-expand navbar-dark flex-row align-items-md-center ct-navbar bg-{{config("app.theme_color.name")}}"
    data-theme-bg-color="{{config("app.theme_color.name")}}">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center mbi">
                <li class="nav-item text-nowrap d-none d-sm-block">
                    <a href="./" class="nav-link navbar-brand d-block">
                        <img src="{{config("app.logo")}}" class="navbar-brand-img" alt=""
                            style="width: 200px;height: 44px;">
                    </a>
                </li>
                <li class="nav-item text-nowrap">
                    <a href="{{url("/home")}}" class="{{request()->segment(1) == "home" ? "active" : ""}} nav-link"
                        title="{{Translator::phrase("home")}}">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-home"></i>
                            <span class="d-none d-sm-block mb-0 mx-1 m-sm-3 text-sm">
                                {{Translator::phrase("home")}}
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item text-nowrap">
                    <a href="{{url("/training")}}"
                        class="{{request()->segment(1) == "training" ? "active" : ""}} nav-link"
                        title="{{Translator::phrase("training")}}">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-graduation-cap"></i>
                            <span class="d-none d-sm-block mb-0 mx-1 text-sm">
                                {{Translator::phrase("training")}}
                            </span>
                        </div>
                    </a>
                </li>


                <li class="nav-item text-nowrap">
                    <a href="{{url("/news-even")}}"
                        class="{{request()->segment(1) == "news-even" ? "active" : ""}} nav-link"
                        title="{{Translator::phrase("news")}}">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-bullhorn"></i>
                            <span class="d-none d-sm-block mb-0 mx-1 text-sm">
                                {{Translator::phrase("news. & .even")}}
                            </span>
                        </div>
                    </a>
                </li>





                <li class="nav-item text-nowrap">
                    <a href="{{url("/about")}}" class="{{request()->segment(1) == "about" ? "active" : ""}} nav-link"
                        title="{{Translator::phrase("about")}}">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle"></i>
                            <span class="d-none d-sm-block mb-0 mx-1 text-sm">
                                {{Translator::phrase("about")}}
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item text-nowrap">
                    <a href="{{url("/contact")}}"
                        class="{{request()->segment(1) == "contact" ? "active" : ""}} nav-link"
                        title="{{Translator::phrase("contact")}}">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-address-book"></i>
                            <span class="d-none d-sm-block mb-0 mx-1 text-sm">
                                {{Translator::phrase("contact")}}
                            </span>
                        </div>
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav align-items-center ml-auto ml-md-auto">
                <li class="nav-item text-nowrap dropdown">
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
                @auth
                <li class="nav-item text-nowrap dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                <img data-alt="{{Auth::user()->name}}" data-src="{{Auth::user()->profile()}}">
                            </span>
                            <div class="media-body ml-2 d-none d-sm-block">
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
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                            <i class="ni ni-user-run"></i>
                            {{ Translator::phrase('logout') }}
                        </a>
                    </div>
                </li>
                @else

                    @if(strtolower(request()->segment(1)) == "login")
                    <li class="nav-item text-nowrap">
                        <a href="{{route("register")}}" class="nav-link btn btn-outline-secondary" title="{{Translator::phrase("register")}}">
                            <div class="d-flex align-items-center">
                                <i class="fal fa-user-plus mr-0"></i>
                                <span class="d-none d-sm-block mb-0 mx-1 text-sm">
                                    {{Translator::phrase("register")}}
                                </span>
                            </div>
                        </a>
                    </li>
                    @elseif(strtolower(request()->segment(1)) == "register")
                    <li class="nav-item text-nowrap">
                        <a href="{{route("login")}}" class="nav-link btn btn-outline-secondary" title="{{Translator::phrase("login")}}">
                            <div class="d-flex align-items-center">
                                <i class="fal fa-sign-in-alt"></i>
                                <span class="d-none d-sm-block mb-0 mx-1 text-sm">
                                    {{Translator::phrase("login")}}
                                </span>
                            </div>
                        </a>
                    </li>
                    @else
                    <li class="nav-item text-nowrap">
                        <a href="{{route("login")}}" class="nav-link" title="{{Translator::phrase("login")}}">
                            <div class="d-flex align-items-center">
                                <i class="fal fa-sign-in-alt"></i>
                                <span class="d-none d-sm-block mb-0 mx-1 text-sm">
                                    {{Translator::phrase("login")}}
                                </span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item text-nowrap">
                        <a href="{{route("register")}}" class="nav-link btn btn-outline-secondary" title="{{Translator::phrase("register")}}">
                            <div class="d-flex align-items-center">
                                <i class="fal fa-user-plus mr-0"></i>
                                <span class="d-none d-sm-block mb-0 mx-1 text-sm">
                                    {{Translator::phrase("register")}}
                                </span>
                            </div>
                        </a>
                    </li>
                    @endif
                @endauth

            </ul>

        </div>
    </div>
</nav>
