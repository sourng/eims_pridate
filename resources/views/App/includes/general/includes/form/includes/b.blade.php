<div class="card m-0">
    <div class="card-header">
        <h3>{{Translator::phrase("social_media")}}</h3>
    </div>
    <div class="card-body">
        <div class="form-row">
            @foreach (config("app.socail") as $media)

            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" for="{{$media["name"]}}" class="form-control-label">
                    {{ Translator:: phrase($media["name"]) }}
                    @if(config("pages.form.validate.rules.".$media["name"]))
                    <span
                        class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text p-1"><i class="{{$media["icon"]}} fa-2x"></i></span>
                        </div>
                        <input type="text" class="form-control" name="{{$media["name"]}}" id="{{$media["name"]}}"
                            placeholder="{{ Translator::phrase($media["name"]) }}" value="{{$media["link"]}}"
                            {{config("pages.form.validate.rules.".$media["name"]) ? "required" : ""}} />

                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
