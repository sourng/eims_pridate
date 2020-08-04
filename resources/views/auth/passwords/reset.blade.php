@extends('layouts.master-v1')
@section("meta")
@section('style')
<!-- Favicon -->
<link rel="icon" href="{{config("app.favicon")}}" type="image/png">

<link rel="stylesheet" href="{{asset("assets/vendor/nucleo/css/nucleo.css")}}" type="text/css">
<link rel="stylesheet" href="{{asset("assets/vendor/@fortawesome/fontawesome-free/css/all.min.css")}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/vendor/animate.css/animate.min.css")}}">
<link rel="stylesheet" href="{{asset("/assets/css/argon.min.css?v=1.1.0")}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/css/custom.css")}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/css/spinner.css")}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/css/icon.css") }}" />
<style>
    .main-content:after {
        content: "";
        background: url("{{asset("/assets/img/brand/bg.webp")}}");
        background-size: 100%;
        opacity: .5;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        position: fixed;
        z-index: -1;

    }
</style>

@endsection

@section("bodyClass","bg-".config("app.theme_color.name"))
@section("content")
<!-- Main content -->
<div class="main-content">
    <!-- Navbar -->

    <nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{route("home")}}">
                <img src="{{config("app.logo")}}">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse"
                aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="{{route("home")}}">
                                <img src="{{config("app.logo")}}">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" data-toggle="dropdown" id="navbarDropdownMenuLink2">
                            <span><img width="26"
                                    src="{{config('app.languages.'.app()->getLocale().".image")}}" /></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink2">
                            @foreach (config('app.languages') as $lang)
                            <li>
                                <a class="dropdown-item {{app()->getLocale() == $lang["code_name"] ? "disabled" : ""}}"
                                    href="{{$lang["action"]["set"]}}">
                                    <span><img width="26" src="{{ $lang["image"]}}" /></span>
                                    <span>{{ Translator::phrase($lang["code_name"],"en")}}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{route("login")}}" class="nav-link">
                            <span class="nav-link-inner--text">{{Translator::phrase('login')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route("register")}}" class="nav-link">
                            <span class="nav-link-inner--text">{{Translator::phrase('register')}}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page content -->
    <div class="container py-7 pb-2">
        <div class="row justify-content-center mt-7">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-{{config("app.theme_color.name")}} shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>{{Translator::phrase('reset_password')}}</small>
                        </div>
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('password.update') }}"
                            class="needs-validation {{$errors ? 'was-validated' : ''}}" novalidate="">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input class="form-control @error('email') is-invalid @enderror"
                                        placeholder="{{Translator::phrase('email')}}" type="email"
                                        value="{{old('email')}}" name="email" required>
                                    @error('email')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                                    </div>
                                    <input class="form-control @error('email') is-invalid @enderror"
                                        placeholder="{{Translator::phrase('password')}}" type="password"
                                        value="{{old('password')}}" name="password" required
                                        autocomplete="new-password">
                                    @error('password')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input class="form-control @error('email') is-invalid @enderror"
                                        placeholder="{{Translator::phrase('password_confirm')}}" type="password"
                                        value="{{old('password-confirm')}}" name="password_confirmation" required
                                        autocomplete="new-password">
                                    @error('password-confirm')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit"
                                    class="btn btn-white my-4">{{Translator::phrase('reset_password')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="py-5" id="footer-main">
        <div class="container">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-xl-6">
                    <div class="copyright text-center text-xl-left text-muted text-white">
                        &copy; 2019 <a href="{{config("app.website")}}" class="font-weight-bold ml-1 text-white"
                            target="_blank">{{config('app.name')}}</a>
                    </div>
                </div>
                <div class="col-xl-6">
                    <ul class="nav nav-footer justify-content-center justify-content-xl-end text-white">

                        <li class="nav-item ">
                            <a href="#" class="nav-link text-white" target="_blank">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white" target="_blank">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white" target="_blank">License</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection
@section("script")

<script src="{{asset("assets/vendor/jquery/dist/jquery.min.js")}}"></script>
<script src="{{asset("assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("assets/vendor/js-cookie/js.cookie.js")}}"></script>
<script src="{{asset("assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js")}}"></script>
<script src="{{asset("assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js")}}"></script>
<script src="{{asset("assets/js/argon.min.js?v=1.1.0")}}"></script>
@endsection
