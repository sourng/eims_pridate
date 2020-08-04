@extends('layouts.master-v1')
@section("meta")
@section('style')
<!-- Favicon -->
<title>{{config("app.name")}} | {{ Translator::phrase("register")}}</title>
<link rel="icon" href="{{config("app.favicon")}}" type="image/png">
<link rel="stylesheet" href="{{asset("assets/vendor/nucleo/css/nucleo.css")}}" type="text/css">
<link rel="stylesheet" href="{{asset('/assets/vendor/@fortawesome/fontawesome-pro/css/pro.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/vendor/animate.css/animate.min.css")}}">
<link rel="stylesheet" href="{{asset("/assets/css/argon.min.css?v=1.1.0")}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/css/custom.css")}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/css/spinner.css")}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/css/icon.css") }}" />
@if (config('app.theme_background'))
<style>
    .main-content:after {
        content: "";
        background: url("{{config('app.theme_background.image')}}");
        background-size: 100%;
        background-repeat: no-repeat;
        background-position: bottom;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        position: fixed;
        z-index: -1;
    }

    .sitting {
        width: 800px;
        height: 800px;
        position: absolute;
        background: url("{{asset('assets/img/icons/siting.webp')}}");
    }
</style>
@endif

@endsection

@section("bodyClass","bg-".config("app.theme_color.name"))
@section("content")
<!-- Main content -->
<div class="main-content">
    <!-- Navbar -->

    @include("Front.includes.navTop")
    <div class="sitting"></div>
    <!-- Page content -->
    <div class="container py-7 pb-2">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-header bg-transparent">
                        <div class="text-muted text-center m-2">
                            <small>{{Translator::phrase('create_new_account.with')}}</small></div>
                        <div class="btn-wrapper text-center">
                            @if (env("FACEBOOK_ENABLED"))
                            <a href="{{url('auth/facebook')}}" class="btn btn-neutral btn-icon">
                                <span class="btn-inner--icon"><img
                                        src="{{asset('../assets/img/icons/common/facebook.svg')}}"></span>
                                <span class="btn-inner--text">{{Translator::phrase('facebook')}}</span>
                            </a>
                            @endif
                            @if (env("GOOGLE_ENABLED"))

                            <a href="{{url('auth/google')}}" class="btn btn-neutral btn-icon">
                                <span class="btn-inner--icon"><img
                                        src="{{asset('../assets/img/icons/common/google.svg')}}"></span>
                                <span class="btn-inner--text">{{Translator::phrase('google')}}</span>
                            </a>
                            @endif

                        </div>
                    </div>
                    <div class="card-body px-lg-5 py-lg-3">
                        <div class="text-center text-muted mb-4">
                            <small>{{Translator::phrase('or.create_new_account')}}</small>
                        </div>
                        <form method="POST" action="{{ route('register') }}"
                            class="needs-validation {{$errors ? 'has-validated' : 'was-validated'}}" novalidate="">
                            @csrf
                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input class="form-control @error('name') is-invalid @enderror"
                                        placeholder="{{Translator::phrase('name')}}" type="text" value="{{old('name')}}"
                                        name="name" required>
                                    @error('name')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>
                            </div>
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
                                    class="btn text-white bg-{{config("app.theme_color.name")}} my-4">{{Translator::phrase('register')}}</button>
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
