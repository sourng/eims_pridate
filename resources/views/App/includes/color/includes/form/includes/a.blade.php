<style>
.color-swatch-header .selected {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100%;
        }

        .color-swatch-header .selected-item-wrap {
            position: relative;
            left: 50%;
            top: 50%;
            float: left;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 2em;
        }
        </style>
@foreach ($response['data'] as $color)
<div class="col-md-3">
    <div class="color-swatch" data-toggle="theme_color" title="{{$color["name"]}}" data-color-name="{{$color["color_name"]}}" data-id="{{$color["id"]}}">
        <div class="color-swatch-header bg-{{$color["color_name"]}}">
            @if ($color["id"] == config("app.theme_color.id"))
            <div class="selected">
                <div class="selected-item-wrap">
                    <i class="fas fa-check"></i>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endforeach
