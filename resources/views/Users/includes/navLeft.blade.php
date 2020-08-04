<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="{{route("home")}}">
                <img src="{{config("app.logo")}}" class="navbar-brand-img" alt="...">
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block active" data-action="sidenav-unpin"
                    data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->segment(2) == "dashboard" || request()->segment(2) == null) ? "active text-blue": "" }}"
                            href="{{URL::to(config("pages.host").config("pages.path")."/dashboard")}}">
                            <i class="fas fa-tv"></i>
                            <span class="nav-link-text">{{Translator::phrase("dashboard")}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{request()->segment(2) == "feed" ? "active text-blue": "" }}"
                            href="{{URL::to(config("pages.host").config("pages.path")."/feed")}}">
                            <i class="fas fa-bullhorn"></i>
                            <span class="nav-link-text">{{Translator::phrase("news. & .even")}}</span>
                        </a>
                    </li>
                   

                </ul>
                <hr class="my-3">
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->segment(2) == "profile") ? "active text-blue": "" }}"
                            href="{{URL::to(config("pages.host").config("pages.path")."/profile")}}"
                            data-toggle="collapse" data-target="#navbar-profile" profile="button"
                            aria-expanded="{{ (request()->segment(2) == "profile") ? "true": "false" }}"
                            aria-controls="navbar-tables">
                            <i class="fas fa-user"></i>
                            <span class="nav-link-text">{{Translator:: phrase("profile")}} </span>
                        </a>

                        <div class="collapse {{ (request()->segment(2) == "profile") ? "show": "" }}"
                            id="navbar-profile">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{URL::to(config("pages.host").config("pages.path")."/profile/general")}}"
                                        class="nav-link  {{(request()->segment(2) == "profile") ? ((request()->segment(3) == "general" || request()->segment(3) == null) ? "active text-blue": ""): ""}}">
                                        {{Translator:: phrase("general")}}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{URL::to(config("pages.host").config("pages.path")."/profile/password")}}"
                                        class="nav-link  {{(request()->segment(2) == "profile") ? ((request()->segment(3) == "password") ? "active text-blue": ""): "" }}">
                                        {{Translator:: phrase("password")}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
