<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    @if (Internet::conneted())
    <link href="https://fonts.googleapis.com/css?family=Battambang&display=swap" rel="stylesheet">
    @endif
    @if (config("app.title"))
    <title>{{config("app.title")}}</title>
    @endif
    @yield("meta")
    @yield("style")
    <style>
        @font-face {
            font-family: "Khmer OS Battambang";
            src: url({{asset("assets/fonts/KhmerOS_battambang.ttf")}});
        }

        :root {
            --app-color : {{config('app.theme_color.color')}};
        }

        .plyr__control--overlaid {
            background: var(--app-color);
        }

        .plyr--full-ui input[type=range] {
            color: var(--app-color);
        }

        .plyr--video .plyr__control.plyr__tab-focus,
        .plyr--video .plyr__control:hover,
        .plyr--video .plyr__control[aria-expanded=true] {
            background: var(--app-color);
        }

        .plyr__menu__container .plyr__control[role=menuitemradio][aria-checked=true]::before {
            background: var(--app-color);
        }

        .plyr__control.plyr__tab-focus {
            box-shadow: 0 0 0;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected],
        .select2-container--default .select2-results__option[aria-selected=true] {
            color: var(--app-color);
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            color: white;
            background-color: var(--app-color);
        }

        .ct-comment,
        .ct-replied {
            margin-bottom: .5rem;
            padding-left: .5rem;
            border-left: 3px solid var(--app-color);
        }

        .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
            border-color: var(--app-color);
        }

        .custom-control-input:checked~.custom-control-label::before {
            background-color: var(--app-color);
        }

        .spinner {
            border-color: var(--app-color);
            border-top-color: rgba(255, 255, 255, .5);
            border-top-style: dashed;
        }


        .custom-radio .custom-control-input:checked~.custom-control-label::before {
            border-color: var(--app-color);
        }

        .custom-control-input:not(:disabled):active~.custom-control-label::before {
            border-color: var(--app-color);
            background-color: var(--app-color);
        }

        .custom-checkbox .custom-control-input:disabled:checked~.custom-control-label::before,
        .custom-radio .custom-control-input:disabled:checked~.custom-control-label::before {
            background-color: var(--app-color);
        }

        .tab-content {
            background: #fdfdfd;
            line-height: 25px;
            border: 1px solid #ddd;
            padding: 30px 25px;

            border-top: 5px solid var(--app-color);

            border-bottom: 5px solid var(--app-color);
        }

        [data-increment="true"]>p {
            counter-increment: count
        }

        [data-increment="true"]>p:before {
            content: counter(count);
            display: inline-block;
            text-align: center;
            font-size: 1.5em;
            line-height: 1.3em;
            padding: 2px 10px;
            font-weight: bold;
            color: white;
            border-radius: 50%;
            position: absolute;
            left: 3rem;

            background-color: var(--app-color);
        }

        .icon-actions.media a {
            cursor: pointer;
        }

        .icon-actions.media .active {
            background-color: var(--app-color);
        }

        .icon-actions.media .active span,
        .icon-actions.media .active i {
            color: white
        }

        [data-toggle="collapse"] .fa-plus-minus:before,
        [data-toggle="collapse-table"] .fa-plus-minus:before {
            content: "\f068";
        }

        [data-toggle="collapse"].collapsed .fa-plus-minus:before,
        [data-toggle="collapse-table"].collapsed .fa-plus-minus:before {
            content: "\f067";
        }

        .table-xs td,
        .table-xs th,
        .table+.table td,
        .table+.table th {
            /* border: 1px solid #ccc; */
            padding: .5rem;
        }

        .modal form {
            display: contents;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: '/';
        }

        .print-option {
            display: none;
        }

        body {
            padding-right: 0 !important;
            overflow-y: scroll !important;
        }

        body.modal-open,
        body.viewer-open,
        body.mgs-grid-open {
            padding-right: 17px !important;
            overflow: hidden !important;
        }

        @media (max-width: 576px) {

            body.modal-open,
            body.viewer-open,
            body.mgs-grid-open {
                padding-right: 0px !important;
                overflow: hidden !important;
            }

            ul.navbar-nav.mbi li {
                margin: auto 8px;
                font-size: large;
            }
        }

        .carousel-indicators li {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: none;
        }

        .fc-event .fc-title {
            font-weight: 300;
        }

        .viewer-footer,
        .viewer-title {
            overflow: unset;
        }

        .viewer-title {
            margin: 0 5% 10px;
        }

        .map-marker:hover {
            cursor: pointer;
        }

        video#player {
            width: 100%
        }

        .map-marker:hover>i {
            color: tomato;
        }

        .btn-group-colors>.btn:before {
            font-family: NucleoIcons, sans-serif;
            content: '';
        }

        .select2-container--default .select2-results__option:not(.loading-results)[aria-disabled=true],
        .select2-container--default .select2-results__option:not(.loading-results)[aria-selected=true] {
            display: none;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #fff;
            background: var(--app-color);
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #fff;
        }
    </style>
</head>

<body class="{{isset($_COOKIE["sidenav-state"]) ? ($_COOKIE["sidenav-state"] == "pinned" ? "g-sidenav-show g-sidenav-pinned" : "g-sidenav-hidden") : "g-sidenav-show g-sidenav-pinned"}}">
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="app">
        <div id="fb-root"></div>
        @yield("content")
        @include("layouts.jsvars")
        @yield("script")
        @include('sweetalert::alert')
    </div>
</body>

</html>
