<div class="row">
    <div class="col">
        <div class="card">
            @include(config("pages.parent").".includes.view.includes.body")
            @if (!request()->ajax())
            <div class="card-footer">
                <a href="{{url(config("pages.host").config("pages.path").config("pages.pathview")."list")}}"
                    class="btn btn-default" type="button">
                    {{ Translator:: phrase("back") }}
                </a>
            </div>
            @endif

        </div>
    </div>
</div>
