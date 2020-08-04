<div class="card-footer p-2">
    <div class="col px-0 mb-3 icon-actions media">
        <input type="hidden" name="type" value="text" id="post-type">
        <a data-type="text" class="border text-nowrap active text-sm rounded-pill p-1 align-items-center"
            data-toggle="feed-media" data-target="#post-theme-color">
            <span class="text-sm text-muted">
                <i class="fas fa-text"></i>
                <span class="font-weight-500">{{Translator::phrase("text")}}</span>
            </span>
        </a>
        <a data-type="media" class="border text-nowrap text-sm rounded-pill p-1 align-items-center"
            data-toggle="feed-media" data-target="#post-media">
            <span class="text-sm text-muted">
                <i class="fas fa-images"></i>
                <span class="font-weight-500">{{Translator::phrase("Photo. / .Video")}}</span>
            </span>
        </a>

        <a data-type="link" class="border text-nowrap text-sm rounded-pill p-1 align-items-center"
            data-toggle="feed-media" data-target="#post-link">
            <span class="text-sm text-muted">
                <i class="fas fa-link"></i>
                <span class="font-weight-500">{{Translator::phrase("link")}}</span>
            </span>
        </a>
    </div>
    <div class="float-right text-right d-none" data-target="post-btn">
        <div class="form-row mr-3">
            <label class="custom-toggle who-see">
                <input type="checkbox" name="who_see" value="only_me">
                <span class="custom-toggle-slider rounded-circle" data-label-off="{{Translator::phrase("public")}}"
                    data-label-on="{{Translator::phrase("only_me")}}"></span>
            </label>
        </div>
        <button type="submit" class="btn btn-sm text-white bg-{{config("app.theme_color.name")}}" data-update-text="{{Translator::phrase("post")}}">
            <span class="d-flex align-items-center">
                <i class="fas fa-paper-plane"></i>
                <span class="d-none d-sm-block text-sm">
                    {{Translator::phrase("post")}}
                </span>

            </span>
        </button>
    </div>
</div>
