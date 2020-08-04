<div class="card">
    <div class="card-header p-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            (D) {{ Translator:: phrase("personal_contact") }}
        </label>
    </div>
    <div class="card-body">

        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.phone")}}" class="form-control-label"
                    for="phone">

                    {{ Translator:: phrase("phone") }}
                    @if(config("pages.form.validate.rules.phone"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span> @endif
                </label>


                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="phone" class="form-control" placeholder="{{ Translator:: phrase("phone") }}"
                            value="{{config("pages.form.data.phone")}}"
                            {{config("pages.form.validate.rules.phone") ? "required" : ""}}
                            id="phone" name="phone" />

                    </div>
                </div>

            </div>

            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.email")}}" class="form-control-label"
                    for="email">

                    {{ Translator:: phrase("email") }}
                    @if(config("pages.form.validate.rules.email"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span> @endif

                </label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" class="form-control" id="email"
                            placeholder="{{ Translator:: phrase("email") }}" value="{{config("pages.form.data.email")}}"
                            {{config("pages.form.validate.rules.email") ? "required" : ""}}
                            name="email" />
                    </div>
                </div>

            </div>

        </div>

        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.extra_info")}}" class="form-control-label"
                    for="student_extra_info">
                    {{ Translator:: phrase("extra_info") }}
                    @if(config("pages.form.validate.rules.student_extra_info"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span> @endif
                </label>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info"></i></span>
                        </div>
                        <textarea type="student_extra_info" class="form-control" id="student_extra_info"
                            placeholder="{{ Translator:: phrase("extra_info") }}" value=""
                            {{config("pages.form.validate.rules.student_extra_info") ? "required" : ""}}
                            name="student_extra_info">{{config("pages.form.data.extra_info")}}</textarea>

                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.photo")}}" class="form-control-label"
                    for="photo">
                    {{ Translator:: phrase("photo") }} (4 x 6)
                    @if(config("pages.form.validate.rules.photo"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span> @endif
                </label>
                <div class="dropzone dropzone-single" id="photo" data-toggle="dropzone"
                    data-dropzone-url="{{ config("pages.form.data.photo")}}">
                    <div class="fallback">
                        <div class="custom-file">
                            <input type="file" placeholder="{{ Translator:: phrase("drop_photo_here") }}"
                                class="custom-file-input" name="photo"
                                {{config("pages.form.validate.rules.photo") ? "required" : ""}} />
                            <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123"
                                class="custom-file-label"
                                for="photo">{{ Translator:: phrase("choose.photo") }}</label>
                        </div>
                    </div>

                    <div class="dz-preview dz-preview-single">
                        <div class="dz-preview-cover">
                            <img class="dz-preview-img" data-src="{{ config("pages.form.data.photo")}}" alt
                                data-dz-thumbnail>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
