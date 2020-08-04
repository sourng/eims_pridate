<div class="card m-0">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            B
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                                    title="{{config("pages.form.validate.questions.extra_info")}}"
                                    class="form-control-label" for="description">
                                    {{ Translator:: phrase("extra_info") }}
                                    @if(config("pages.form.validate.rules.description"))
                                    <span class="badge badge-md badge-circle badge-floating badge-danger"
                                        style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span> @endif
                                </label>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-info"></i></span>
                                        </div>
                                        <textarea type="text" class="form-control" id="description"
                                            placeholder="{{ Translator:: phrase("extra_info") }}" value=""
                                            {{config("pages.form.validate.rules.description") ? "required" : ""}}
                                            name="description">{{config("pages.form.data.description")}}</textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="photo">
                            {{ Translator:: phrase("photo") }} (4 x 6)
                            @if(array_key_exists("photo",config("pages.form.validate.rules")))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif
                        </label>
                        <div class="dropzone dropzone-single" data-toggle="dropzone"
                            data-dropzone-url="{{config("pages.form.data.photo")}}?type=original">
                            <div class="fallback">
                                <div class="custom-file">
                                    <input type="file" placeholder="{{ Translator:: phrase("drop_photo_here") }}"
                                        class="custom-file-input" id="dropzoneBasicUpload" name="photo"
                                        {{(array_key_exists("photo", config("pages.form.validate.rules"))) ? "required" : ""}} />
                                    <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123"
                                        class="custom-file-label"
                                        for="dropzoneBasicUpload">{{ Translator:: phrase("choose.photo") }}</label>
                                </div>
                            </div>

                            <div class="dz-preview dz-preview-single">
                                <div class="dz-preview-cover">
                                    <img class="dz-preview-img"
                                        data-src="{{config("pages.form.data.photo")}}?type=original" alt
                                        data-dz-thumbnail>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-12 mb-3">
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
