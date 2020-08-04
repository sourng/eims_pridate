<div class="card-footer">
    @if (!request()->ajax())
        <a href="{{url(config("pages.host").config("pages.path").config("pages.pathview")."list")}}"
           class="btn btn-default" type="button">{{ Translator:: phrase("back") }}</a>
    @endif
</div>
