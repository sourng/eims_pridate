@extends("layouts.master-v1")
@section("meta")
    @foreach(config("app.meta") as $keys)
    @for($i = 0 ; $i< count($keys);$i++) @php $meta=array();$content=array(); @endphp @foreach ($keys[$i] as $name=> $item)
        @php $meta[] =
        $name ; @endphp @endforeach
        @if(count($meta) == 1)
        <meta {{$meta[0]}}="{{ $keys[$i][$meta[0]] }}" />
        @else
        <meta {{$meta[0]}}="{{ $keys[$i][$meta[0]] }}" {{$meta[1]}}="{{ $keys[$i][$meta[1]] }}" />
        @endif @endfor @endforeach
@endsection


    @section("style")
    <link rel="icon" href="{{config("app.favicon")}}" type="image/png">

    <link rel="stylesheet" href="{{asset("/assets/vendor/nucleo/css/nucleo.css")}}" type="text/css">
    <link rel="stylesheet" href="{{asset("/assets/vendor/@fortawesome/fontawesome-pro/css/pro.min.css")}}"
        type="text/css">

    <link rel="stylesheet" href="{{asset("/assets/vendor/select2/4.0.2/css/select2.min.css") }}" />
    <link rel="stylesheet" href="{{asset("/assets/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
    <link rel="stylesheet" href="{{asset("/assets/vendor/animate.css/animate.min.css")}}">
    <link rel="stylesheet" href="{{asset("/assets/css/argon.min.css?v=1.1.0")}}" type="text/css">
    <link rel="stylesheet" href="{{asset("/assets/css/custom.css")}}" type="text/css">
    <link rel="stylesheet" href="{{asset("/assets/css/spinner.css")}}" type="text/css">
    <link rel="stylesheet" href="{{asset("/assets/css/circle.css")}}" type="text/css">
    <link rel="stylesheet" href="{{asset("/assets/css/icon.css") }}" />
    <link rel="stylesheet" href="{{asset("/assets/vendor/emojionearea/dist/emojionearea.min.css")}}">
    <link rel="stylesheet" href="{{asset("/assets/vendor/swiper/dist/swiper.min.css")}}">
    <link rel="stylesheet" href="{{asset("/assets/vendor/feed/dist/feed.css")}}">
    <link rel="stylesheet" href="{{asset("/assets/vendor/plyr/dist/plyr.css")}}" />
    <link rel="stylesheet" href="{{asset("/assets/vendor/reaction/dist/reaction.css")}}" />
    <link rel="stylesheet" href="{{asset("/styles/xcode.css")}}" />
    <link rel="stylesheet" href="{{asset("/assets/css/images-grid.css")}}">
    <link rel="stylesheet" href="{{asset("/assets/vendor/hovercard/dist/jquery.hovercard.css")}}">
    <link rel="stylesheet" href="{{asset("/assets/vendor/jquery-tooltipster/dist/jquery.tooltipster.css")}}">
    <link rel="stylesheet" href="{{asset("/assets/vendor/jquery-tooltipster/dist/hovercard.css")}}">
    <link rel="stylesheet" href="{{asset("/assets/vendor/jquery-sticker/dist/jquery.sticker.css")}}">
    @endsection



    @section("content")
    @include(Auth::user()->role('view_path').".includes.navLeft")
    <div class="main-content" id="panel">
        @include(Auth::user()->role('view_path').".includes.navTop")
        <div class="container-fluid">
            @include(config("pages.view"))
            @include("ActivityFeed.includes.model.index")
        </div>
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
    <script src="{{asset("/assets/vendor/emojionearea/dist/emojionearea.min.js")}}"></script>
    <script src="{{asset("/assets/js/custom/images-grid.js")}}"></script>
    <script src="{{asset("/assets/vendor/dragscroll/dragscroll.js")}}"></script>
    <script src="{{asset("/assets/vendor/plyr/dist/plyr.js")}}"></script>
    <script src="{{asset("/assets/vendor/hovercard/dist/jquery.hovercard.js")}}"></script>
    <script src="{{asset("/assets/vendor/jquery-tooltipster/dist/jquery.tooltipster.js")}}"></script>
    <script src="{{asset("/assets/vendor/jquery-sticker/dist/jquery.sticker.js")}}"></script>
    <script src="{{asset("/assets/vendor/feed/dist/feed.js")}}"></script>
    <script src="{{asset("/assets/js/custom/ajaxTableData.js")}}"></script>
    <script src="{{asset("/assets/js/argon.min.js?v=1.1.0")}}"></script>
    @endsection
