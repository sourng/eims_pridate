<div id="post-theme-color" class="collapse background my-2">
    <hr class="my-2">
    <div class="d-flex">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="ckk-theme-color" data-target="#bbg">
            <label class="custom-control-label" for="ckk-theme-color">
                <span class="text-muted">
                    {{Translator::phrase("background")}}
                </span>
            </label>
        </div>

        <div class="text-right ml-auto"><span class="text-sm" id="limit-words-count"></span></div>
    </div>
    <div id="bbg" class="py-2 collapse btn-group-toggle btn-group-colors" data-toggle="buttons">
        @foreach ($theme_color['data'] as $color)
        <label class="btn bg-gradient-{{$color["color_name"]}} m-1" data-toggle="post-background" data-target=".post-message.emojionearea"
            data-color="bg-gradient-{{$color["color_name"]}}" data-id="{{$color["id"]}}">
            <input type="radio" name="theme_color" value="{{$color["id"]}}"
                autocomplete="off">
        </label>
        @endforeach
    </div>
</div>
