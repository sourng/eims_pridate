<div class="card">
    <div class="card-header">
        <h5 class="h3 mb-0">
            {{ Translator:: phrase("edit.card") }}
        </h5>
    </div>
    <div class="card-header">
        <label class="btn btn-outline-primary" for="front_card">
            <img width="25px" src="{{config("pages.form.data.front")}}" alt="">
            {{Translator::phrase("frame_front")}}
        </label>
        <input hidden type="file" name="front_card" id="front_card">

        <label class="btn btn-outline-primary" for="back_card">
            <img width="25px" src="{{config("pages.form.data.background")}}" alt="">
            {{Translator::phrase("frame_background")}}
        </label>
        <input hidden type="file" name="back_card" id="back_card">

        <button id="layout" class="btn btn-outline-primary">
            <i class="fas fa-columns"></i>
            {{Translator::phrase("layout")}}
        </button>
        <div class="dropdown" data-close="false">
            <a class="btn btn-outline-primary " href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="fad fa-cog"></i>
                <span class="caret"></span>
            </a>
            <div class="p-2 dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-menu-arrow">
                @foreach ($cards["all"] as $key => $item)
                <div class="custom-control custom-checkbox">
                    <input {{array_key_exists($key,$cards["selected"]) ? "checked" : "" }} value="{{$key}}"
                        type="checkbox" class="custom-control-input card-value-check" id="customCheck-{{$key}}">
                    <label class="custom-control-label" for="customCheck-{{$key}}">{{$item}}</label>
                </div>
                @endforeach
            </div>
        </div>
    </div>


    <div class="card-body">
        <style>
            [id^="stage"] {
                margin: auto;
                width: 704px !important;
                @if ($cards["frame"] && $cards["frame"]["layout"]=="vertical")
                /* height: 350px;
               width: 504px !important; */
                @endif
            }

            [id^="stage"] .konvajs-content {
                margin: auto;
            }
        </style>
        @if ($cards["user"] == null)
        <div class="text-danger text-center">
            {{ Translator:: phrase("no_data") }}
        </div>
        @endif
        <div class="col-12">
            <div id="stage" data-toggle="card-maker" data-layout="{{$cards["frame"]["layout"]}}"
                data-front="{{$cards["frame"]["front"]}}" data-background="{{$cards["frame"]["background"]}}"
                data-user='{!! json_encode($cards["user"])!!}'></div>
        </div>
    </div>

    <div class="card-footer">
        <button class="btn btn-primary ml-auto float-right {{request()->ajax() ? "d-none" : ""}}" type="submit">
            {{ Translator:: phrase("update") }}
        </button>
    </div>
</div>
