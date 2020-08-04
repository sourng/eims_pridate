@extends("layouts.master-v1")
@section("meta")
{!! config("app.meta_html") !!}
@endsection
@section("style")
<link rel="icon" href="{{config("app.favicon")}}" type="image/png">

<link rel="stylesheet" href="{{asset('/assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('/assets/vendor/@fortawesome/fontawesome-pro/css/pro.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('/assets/vendor/select2/dist/css/select2.min.css') }}" />
<link rel="stylesheet" href="{{asset('/assets/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset("/assets/vendor/fullcalendar/dist/fullcalendar.min.css")}}">
<link rel="stylesheet" href="{{asset('/assets/vendor/animate.css/animate.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/css/argon.min.css?v=1.1.0')}}" type="text/css">
<link rel="stylesheet" href="{{asset('/assets/css/custom.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('/assets/css/spinner.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/vendor/quill/dist/quill.core.css") }}" />

<link rel="stylesheet" href="{{asset("/assets/css/icon.css") }}" />
<link rel="stylesheet" href="{{asset("/assets/css/images-grid.css")}}">
<link rel="stylesheet" href="{{asset("/assets/vendor/emojionearea/dist/emojionearea.min.css")}}">
<link rel="stylesheet" href="{{asset("/assets/vendor/swiper/dist/swiper.min.css")}}">
<link rel="stylesheet" href="{{asset("/assets/vendor/feed/dist/feed.css")}}">
<link rel="stylesheet" href="{{asset("/assets/vendor/plyr/dist/plyr.css")}}" />
<link rel="stylesheet" href="{{asset("/assets/vendor/reaction/dist/reaction.css")}}" />
<link rel="stylesheet" href="{{asset("/styles/xcode.css")}}" />
<link rel="stylesheet" href="{{asset("/assets/vendor/hovercard/dist/jquery.hovercard.css")}}">
<link rel="stylesheet" href="{{asset("/assets/vendor/jquery-tooltipster/dist/jquery.tooltipster.css")}}">
<link rel="stylesheet" href="{{asset("/assets/vendor/jquery-tooltipster/dist/hovercard.css")}}">
<link rel="stylesheet" href="{{asset("/assets/vendor/jquery-sticker/dist/jquery.sticker.css")}}">

<style>
    .carousel-control-next,
    .carousel-control-prev {
        width: 5%
    }

    footer {
        padding: 50px 0 !important;
        background: #2C343E !important;
    }

    section .section-title {
        text-align: center;
        color: #007b5e;
        margin-bottom: 50px;
        text-transform: uppercase;
    }

    .footer .title {
        padding-left: 10px;
        border-left: 3px solid #eeeeee;
        padding-bottom: 6px;
        margin-bottom: 20px;
        color: #ffffff;
    }

    .footer a {
        color: #ffffff;
        text-decoration: none !important;
        background-color: transparent;
        -webkit-text-decoration-skip: objects;
    }

    .footer ul.social li {
        padding: 3px 0;
    }

    .footer ul.social li a i {
        margin-right: 5px;
        font-size: 25px;
        -webkit-transition: .5s all ease;
        -moz-transition: .5s all ease;
        transition: .5s all ease;
    }

    .footer ul.social li:hover a i {
        font-size: 30px;
        margin-top: -10px;
    }

    .footer ul.social li a,
    .footer ul.quick-links li a {
        color: #ffffff;
    }

    .footer ul.social li a:hover {
        color: #eeeeee;
    }

    .footer ul.quick-links li {
        padding: 3px 0;
        -webkit-transition: .5s all ease;
        -moz-transition: .5s all ease;
        transition: .5s all ease;
    }

    .footer ul.quick-links li:hover {
        padding: 3px 0;
        margin-left: 5px;
        font-weight: 700;
    }

    .footer ul.quick-links li a i {
        margin-right: 5px;
    }

    .footer ul.quick-links li:hover a i {
        font-weight: 700;
    }

    @media (max-width:767px) {
        .footer h5 {
            padding-left: 0;
            border-left: transparent;
            padding-bottom: 0px;
            margin-bottom: 10px;
        }
    }

    .img-responsive {
        object-fit: contain !important;
    }

    .navbar-dark .navbar-nav .active>.nav-link,
    .navbar-dark .navbar-nav .nav-link.active,
    .navbar-dark .navbar-nav .nav-link.show,
    .navbar-dark .navbar-nav .show>.nav-link {
        font-weight: bold;
    }

    .modal.card-modal.in.show {
        z-index: 10000;
    }

    .im-col-1,
    .im-col-2 {
        width: 50%;
    }

    textarea[name="message"] {
        height: 200px !important;
    }
</style>

@endsection
@section("bodyClass","g-sidenav-show g-sidenav-pinned")
@section("content")
<div class="main-content" id="panel">
    @include('Front.includes.navTop')
    <div class="container">
        <div class="row">
            @include(config("pages.view"))
        </div>
    </div>
    @if (config("pages.parameters.param1") != "news-even")
    @include('Front.includes.navFooter')
    @endif

</div>

@endsection

@section("script")
<script src="{{asset('/assets/vendor/lazyload/intersection-observer.js')}}"></script>
<script src="{{asset('/assets/vendor/lazyload/lazyload.min.js')}}"></script>
<script src="{{asset("/assets/vendor/swiper/dist/swiper.min.js")}}"></script>

<script src="{{asset("/assets/vendor/jquery/dist/jquery.min.js")}}"></script>
<script src="{{asset("/assets/vendor/jquery/dist/jquery-ui.min.js")}}"></script>
<script src="{{asset("/assets/vendor/jquery/dist/jquery-2.1.4.min.js")}}"></script>
<script src="{{asset('/assets/js/custom/urlhelper.js')}}"></script>

<script src="{{asset("/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("/assets/vendor/sweetalert2/dist/sweetalert2.min.js")}}"></script>
<script src="{{asset("/assets/vendor/js-cookie/js.cookie.js")}}"></script>
<script src="{{asset("/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js")}}"></script>
<script src="{{asset("/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js")}}"></script>
<script src="{{ ('/assets/vendor/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset("/assets/vendor/select2/dist/js/select2.min.js")}}"></script>
<script src="{{asset("/assets/vendor/select2/dist/js/select2.dropdownPosition.js")}}"></script>

<script src="{{asset("/assets/vendor/nouislider/distribute/nouislider.min.js")}}"></script>
<script src="{{asset("/assets/vendor/quill/dist/quill.min.js")}}"></script>
<script src="{{asset("/assets/vendor/dropzone/dist/min/dropzone.min.js")}}"></script>
<script src="{{asset("/assets/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js")}}"></script>

<script src="{{asset("/assets/vendor/anchor-js/anchor.min.js")}}"></script>
<script src="{{asset("/assets/vendor/clipboard/dist/clipboard.min.js")}}"></script>
<script src="{{asset("/assets/vendor/holderjs/holder.min.js")}}"></script>
<script src="{{asset("/assets/vendor/prismjs/prism.js")}}"></script>

<script src="{{asset('/assets/vendor/chart.js/dist/Chart.min.js')}}"></script>
<script src="{{asset('/assets/vendor/chart.js/dist/Chart.extension.js')}}"></script>
<script src="{{asset('/assets/vendor/bootstrap/dist/js/bootstrap-editable.min.js')}}"></script>
<script src="{{asset("/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")}}"></script>
<script src="{{asset("/assets/vendor/validatorjs/dist/validator.js")}}"></script>
<script src="{{asset("/assets/vendor/moment.js/2.24.0/min/moment.min.js")}}"></script>
<script src="{{asset("/assets/vendor/fullcalendar/dist/fullcalendar.min.js")}}"></script>
<script src="{{ asset("/assets/vendor/timeago/jquery.timeago.js")}}"></script>
@if (app()->getLocale() !== "en")
<script src="{{ asset("/assets/vendor/timeago/locales/jquery.timeago.".app()->getLocale().".js")}}"></script>
<script src="{{asset("/assets/vendor/fullcalendar/dist/locale/".app()->getLocale().".js")}}"></script>
<script src="{{asset("/assets/vendor/validatorjs/dist/lang/".app()->getLocale().".js")}}"></script>
<script
    src="{{asset("/assets/vendor/bootstrap-datepicker/dist/locales/bootstrap-datepicker.".app()->getLocale().".min.js")}}">
</script>
@endif

<script src="{{asset('/assets/js/custom/validation.js')}}"></script>
<script src="{{asset('/assets/js/custom/replace-with-tag.js')}}"></script>
<script src="{{asset('/assets/js/custom/form-modal.js')}}"></script>
<script src="{{asset('/assets/vendor/autogrow/autogrow-ui.js')}}"></script>
<script src="{{asset('/assets/js/custom/main-content.js')}}"></script>
<script src="{{asset("/assets/vendor/jquery-textcomplete/dist/jquery.textcomplete.js")}}"></script>
<script src="{{asset("/assets/vendor/hovercard/dist/jquery.hovercard.js")}}"></script>
<script src="{{asset("/assets/vendor/jquery-sticker/dist/jquery.sticker.js")}}"></script>
<script src="{{asset("/assets/vendor/jquery-tooltipster/dist/jquery.tooltipster.js")}}"></script>
<script src="{{asset("/assets/vendor/emojionearea/dist/emojionearea.min.js")}}"></script>
<script src="{{asset("/assets/js/custom/images-grid.js")}}"></script>
<script src="{{asset("/assets/vendor/dragscroll/dragscroll.js")}}"></script>
<script src="{{asset("/assets/vendor/plyr/dist/plyr.js")}}"></script>
<script src="{{asset("/assets/vendor/feed/dist/feed.js")}}"></script>
<script src="{{asset("/assets/js/custom/ajaxTableData.js")}}"></script>
<script src="{{asset("/assets/js/argon.min.js?v=1.1.0")}}"></script>
@endsection
