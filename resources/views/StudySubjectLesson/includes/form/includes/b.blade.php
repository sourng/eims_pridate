<div class="card">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            {{config("pages.form.data.title")}}
        </label>
    </div>
    <div class="card-body">
        @if(config("pages.form.data.source_file"))
        <iframe src="{{config("pages.form.data.source_file")}}" frameborder="0" scrolling="no" class="w-100"
            height="700">
        </iframe>
        <div class="video-responsive">
            {!!config("pages.form.data.source_link.youtube.iframe") !!}
        </div>
        <div class="video-responsive">
            {!!config("pages.form.data.source_link.facebook.iframe") !!}
        </div>
        @endif
    </div>
</div>
