@extends("layouts.master-v1")
@section("meta")
{!! config("app.meta_html") !!}
@endsection


@section("style")
<link rel="icon" href="{{config("app.favicon")}}" type="image/png">

<link rel="stylesheet" href="{{asset("/assets/vendor/nucleo/css/nucleo.css")}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/vendor/@fortawesome/fontawesome-pro/css/pro.min.css")}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/vendor/fullcalendar/dist/fullcalendar.min.css")}}">
<link rel="stylesheet" href="{{asset("/assets/vendor/select2/4.0.2/css/select2.min.css") }}" />
<link rel="stylesheet" href="{{asset("/assets/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
<link rel="stylesheet" href="{{asset("/assets/vendor/animate.css/animate.min.css")}}">
<link rel="stylesheet" href="{{asset("/assets/css/argon.min.css?v=1.1.0")}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/css/custom.css")}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/css/spinner.css")}}" type="text/css">
<link rel="stylesheet" href="{{asset("/assets/css/icon.css") }}" />
<link rel="stylesheet" href="{{asset("/assets/vendor/weather/dist/weather.css")}}" />
<link rel="stylesheet" href="{{asset("/assets/vendor/weather/css/weather-icons.min.css")}}">

<link rel="stylesheet" href="{{asset("/assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css")}}">
<link rel="stylesheet" href="{{asset("/assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css")}}">
<link rel="stylesheet" href="{{asset("/assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css")}}">

<style>
    .card .card-body {
        flex: inherit;
    }

    .table-xs td,
    .table-xs th {
        border: 1px solid #ccc;
        padding: .3rem .3rem !important;
        font-size: .8rem !important;
        text-align: center;
    }

    .table-xs td,
    .table-xs th {
        vertical-align: middle;

    }

    [data-toggle="attendance"] {
        cursor: pointer;
    }

    .custom-control {
        min-width: 1.5rem;
        padding-left: 0rem;
    }

    .custom-control-label::before {
        top: .25rem;
        left: 0.25rem;
    }

    .custom-control-label::after {
        top: .25rem;
        left: 0.25rem;
    }

    table th .custom-control {
        min-height: unset
    }

    /* table th label.custom-control-label {
            display: unset !important;
            vertical-align: super;
        } */
</style>

@endsection



@section("content")
@if (config("pages.parameters.param1") == "print")
@include(config("pages.parent").".includes.print.index")
@else
@include(Auth::user()->role("view_path").".includes.navLeft")
<div class="main-content" id="panel">
    @include(Auth::user()->role("view_path").".includes.navTop")
    <!-- Header -->
    <div class="header bg-{{config("app.theme_color.name")}} pb-6"
        data-theme-bg-color="{{config("app.theme_color.name")}}">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">

                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">
                            @if (Auth::user()->role_id == 6)

                            @if (config("pages.parameters.param1") == "dashboard" ||
                            config("pages.parameters.param1") == null)
                            {{Translator::phrase("dashboard")}}
                            @else
                            {{Translator::phrase("study")}}
                            @endif
                            @else
                            {{Translator::phrase("student")}}
                            @endif

                        </h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item text-white"><i class="fas fa-home"></i></li>
                                @if (Auth::user()->role_id == 6)

                                @if (request()->segment(4) == "list")
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{Translator::phrase("list.".request()->segment(3))}}
                                </li>
                                @elseif(request()->segment(4) != null)
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{url(config("pages.host").config("pages.path").config("pages.pathview")."list")}}">
                                        {{Translator::phrase("list.".request()->segment(3))}}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{Translator::phrase(request()->segment(4))}}
                                </li>
                                @endif
                                @else
                                @if (config("pages.parameters.param1") == null)

                                @elseif(config("pages.parameters.param1") == "list")
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{Translator::phrase("list.student")}}
                                </li>
                                @else
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{url(config("pages.host").config("pages.path").config("pages.pathview")."list")}}">
                                        {{Translator::phrase("list.student")}}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{Translator::phrase(config("pages.parameters.param1"))}}
                                </li>
                                @endif
                                @endif

                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{url()->current()}}" class="btn btn-secondary btn-sm" data-toggle="cotent-refresh"><i
                                class="fas fa-sync-alt"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content container-fluid mt--6 {{Agent::isDesktop() ?: "p-1"}}">
        @include(config("pages.parent").".includes.modal.index")
        @include(config("pages.view"))
        @include(Auth::user()->role("view_path").".includes.navFooter")
    </div>
</div>
@endif
@endsection

@section("script")
<script src="{{asset("/assets/vendor/jquery/dist/jquery.min.js")}}"></script>
<script src="{{asset("/assets/vendor/jquery/dist/jquery-ui.min.js")}}"></script>
<script src="{{asset("/assets/js/custom/urlhelper.js")}}"></script>
<script src="{{asset("/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("/assets/vendor/sweetalert2/dist/sweetalert2.min.js")}}"></script>
<script src="{{asset("/assets/vendor/js-cookie/js.cookie.js")}}"></script>
<script src="{{asset("/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js")}}"></script>
<script src="{{asset("/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js")}}"></script>
<script src="{{asset("/assets/vendor/select2/4.0.2/js/select2.min.js")}}"></script>
<script src="{{asset("/assets/vendor/select2/dist/js/select2.dropdownPosition.js")}}"></script>

<script src="{{asset("/assets/vendor/nouislider/distribute/nouislider.min.js")}}"></script>
<script src="{{asset("/assets/vendor/dropzone/dist/min/dropzone.min.js")}}"></script>

<script src="{{asset("/assets/vendor/list.js/dist/list.min.js")}}"></script>
<script src="{{asset("/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")}}"></script>
<script src="{{asset("/assets/vendor/validatorjs/dist/validator.js")}}"></script>
<script src="{{asset("/assets/vendor/moment.js/2.24.0/min/moment.min.js")}}"></script>
<script src="{{asset("/assets/vendor/fullcalendar/dist/fullcalendar.min.js")}}"></script>

@if (app()->getLocale() !== "en")
<script src="{{asset("/assets/vendor/fullcalendar/dist/locale/".app()->getLocale().".js")}}"></script>
<script src="{{asset("/assets/vendor/select2/4.0.2/js/i18n/".app()->getLocale().".js")}}"></script>
<script src="{{asset("/assets/vendor/datatables.net/i18n/".app()->getLocale().".js")}}"></script>
<script src="{{asset("/assets/vendor/validatorjs/dist/lang/".app()->getLocale().".js")}}"></script>
<script
    src="{{asset("/assets/vendor/bootstrap-datepicker/dist/locales/bootstrap-datepicker.".app()->getLocale().".min.js")}}">
</script>
@endif
<script src="{{asset("/assets/vendor/lazyload/intersection-observer.js")}}"></script>
<script src="{{asset("/assets/vendor/lazyload/lazyload.min.js")}}"></script>
<script src="{{asset("/assets/js/custom/languages.js")}}"></script>
<script src="{{asset("/assets/js/custom/validation.js")}}"></script>
<script src="{{asset("/assets/js/custom/replace-with-tag.js")}}"></script>
<script src="{{asset("/assets/js/custom/form-modal.js")}}"></script>
<script src="{{ asset("/assets/vendor/table/table.js")}}"></script>
<script src="{{asset("/assets/vendor/autogrow/autogrow-ui.js")}}"></script>
<script src="{{asset("/assets/vendor/pagination/simplePagination.js")}}"></script>
<script src="{{asset("/assets/js/custom/main-content.js")}}"></script>
<script src="{{asset("/assets/js/custom/ajaxTableData.js")}}"></script>

<script src="{{asset("/assets/vendor/datatables.net/js/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js")}}"></script>
<script src="{{asset("/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js")}}"></script>
<script src="{{asset("/assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js")}}"></script>
<script src="{{asset("/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js")}}"></script>
<script src="{{asset("/assets/vendor/datatables.net-buttons/js/buttons.flash.min.js")}}"></script>
<script src="{{asset("/assets/vendor/datatables.net-buttons/js/buttons.print.min.js")}}"></script>
<script src="{{asset("/assets/vendor/datatables.net-select/js/dataTables.select.min.js")}}"></script>

<script src="{{asset("/assets/js/argon.min.js?v=1.1.0")}}"></script>
@endsection
