<div class="card m-0">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            C
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.file")}}" class="form-control-label" for="file">
                    {{ Translator:: phrase("File.(.PDF.)") }}

                    @if (config("pages.form.role") == "add")
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>
                <input type="file" data-toggle="read-pdf" accept="application/pdf" data-target=".dz-preview-img"
                    data-view="#read-pdf" class="form-control" id="file" name="file" required>
            </div>

            <div class="col-md-12 mb-3">
                <div id="read-pdf">
                    @if(config("pages.form.data.file"))
                    <iframe src="{{config("pages.form.data.file")}}" frameborder="0" scrolling="no" class="w-100"
                        height="300"></iframe>
                    @endif
                </div>

            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label class="form-control-label" for="description">
                    {{ Translator:: phrase("description") }}

                    @if(config("pages.form.validate.rules.description"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
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
            <div class="col-md-6 mb-3">
                <label class="form-control-label" for="image">
                    {{ Translator:: phrase("image") }}
                    @if(config("pages.form.validate.rules.image"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif
                </label>
                <div class="dropzone dropzone-single" data-toggle="dropzone"
                    data-dropzone-url="{{config("pages.form.data.image")}}?type=original">
                    <div class="fallback">
                        <div class="custom-file">
                            <input type="file" placeholder="{{ Translator:: phrase("drop_image_here") }}"
                                class="custom-file-input" id="dropzoneBasicUpload" name="image"
                                {{config("pages.form.validate.rules.image") ? "required" : ""}} />
                            <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123"
                                class="custom-file-label"
                                for="dropzoneBasicUpload">{{ Translator:: phrase("choose.image") }}</label>
                        </div>
                    </div>

                    <div class="dz-preview dz-preview-single">
                        <div class="dz-preview-cover">
                            <img class="dz-preview-img" data-src="{{config("pages.form.data.image")}}?type=original" alt
                                data-dz-thumbnail>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <div class="custom-checkbox mb-3">
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
        </div>
    </div>
</div>
