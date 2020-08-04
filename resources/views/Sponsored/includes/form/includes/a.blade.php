<div class="card m-0">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            A
        </label>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="form-row">
                    @csrf
                    @if (request()->segment(3) == "view")
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="id">
                            {{ Translator:: phrase("numbering") }}
                        </label>
                        <span class="form-control" id="id" name="id"
                            value="{{config("pages.form.data.id")}}">{{config("pages.form.data.id")}}</span>
                    </div>
                    @endif
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="name">
                            {{ Translator:: phrase("name") }}

                            @if(config("pages.form.validate.rules.name")) <span
                                class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="{{ Translator::phrase("sponsored") }}"
                            value="{{config("pages.form.data.name")}}"
                            {{config("pages.form.validate.rules.name") ? "required" : ""}} />

                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="link">
                            {{ Translator:: phrase("link") }}

                            @if(config("pages.form.validate.rules.link")) <span
                                class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>
                        <input type="text" class="form-control" name="link" id="link"
                            placeholder="{{ Translator::phrase("link") }}" value="{{config("pages.form.data.link")}}"
                            {{config("pages.form.validate.rules.link") ? "required" : ""}} />

                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="description">
                            {{ Translator:: phrase("description") }}

                            @if(config("pages.form.validate.rules.description"))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>

                        <div class="form-group">
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-info"></i></span>
                                </div>
                                <textarea class="form-control" id="description"
                                    placeholder="{{ Translator:: phrase("description") }}" value=""
                                    {{config("pages.form.validate.rules.description") ? "required" : ""}}
                                    name="description">{{config("pages.form.data.description")}}</textarea>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-4">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="image">
                            {{ Translator:: phrase("image") }} (250pixel x 250pixel)

                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset">
                                <i class="fas fa-asterisk fa-xs"></i>
                            </span>

                        </label>
                        <div class="dropzone dropzone-single" data-toggle="dropzone"
                            data-dropzone-url="{{config("pages.form.data.image")}}?type=slide">
                            <div class="fallback">
                                <div class="custom-file">
                                    <input type="file" placeholder="{{ Translator:: phrase("drop_image_here") }}"
                                        class="custom-file-input" id="dropzoneBasicUpload" name="image"
                                        {{config("pages.form.validate.rules.image") ? "required" : ""}} value="image" />
                                    <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123"
                                        class="custom-file-label"
                                        for="dropzoneBasicUpload">{{ Translator:: phrase("choose.image") }}</label>
                                </div>
                            </div>

                            <div class="dz-preview dz-preview-single">
                                <div class="dz-preview-cover">
                                    <img class="dz-preview-img"
                                        data-src="{{config("pages.form.data.image")}}?type=slide" alt data-dz-thumbnail>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                @if (!config("pages.form.data"))
                <div class="form-row">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mb-3">

                            <label class="form-control-label"><i class="fas fa-sticky-note "></i>
                                {{ Translator:: phrase("note") }} </label>
                            <br>
                            <label class="form-control-label">
                                <span class="badge badge-md badge-circle badge-floating badge-danger"
                                    style="background:unset">
                                    <i class="fas fa-asterisk fa-xs"></i></span> <span>
                                    {{ Translator:: phrase("field_required") }}</span> </label>


                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
