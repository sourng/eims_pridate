<div class="col-xl-8 offset-xl-2">
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
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label" for="name">
                                {{ Translator:: phrase("name") }}

                                @if(config("pages.form.validate.rules.name"))
                                <span class="badge badge-md badge-circle badge-floating badge-danger"
                                    style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                                @endif

                            </label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="{{ Translator::phrase("name") }}"
                                value="{{config("pages.form.data.name")}}"
                                {{config("pages.form.validate.rules.name") ? "required" : ""}} />

                        </div>
                    </div>
                    <div class="form-row">


                        <div class="col-md-6 mb-3">
                            <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                                title="{{config("pages.form.validate.questions.email")}}" class="form-control-label"
                                for="email">

                                {{ Translator:: phrase("email") }}
                                @if(config("pages.form.validate.rules.email"))
                                <span class="badge badge-md badge-circle badge-floating badge-danger"
                                    style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span> @endif

                            </label>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="email"
                                        placeholder="{{ Translator:: phrase("email") }}"
                                        value="{{config("pages.form.data.email")}}"
                                        {{config("pages.form.validate.rules.email") ? "required" : ""}} name="email" />
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                                title="{{config("pages.form.validate.questions.phone")}}" class="form-control-label"
                                for="phone">

                                {{ Translator:: phrase("phone") }}
                                @if(config("pages.form.validate.rules.phone"))
                                <span class="badge badge-md badge-circle badge-floating badge-danger"
                                    style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span> @endif
                            </label>


                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="phone" class="form-control"
                                        placeholder="{{ Translator:: phrase("phone") }}"
                                        value="{{config("pages.form.data.phone")}}"
                                        {{config("pages.form.validate.rules.phone") ? "required" : ""}} id="phone"
                                        name="phone" />

                                </div>
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-control-label" for="address">
                                {{ Translator:: phrase("address") }}

                                @if(config("pages.form.validate.rules.address"))
                                <span class="badge badge-md badge-circle badge-floating badge-danger"
                                    style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                                @endif

                            </label>

                            <div class="form-group">
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map"></i></span>
                                    </div>
                                    <textarea class="form-control" id="address"
                                        placeholder="{{ Translator:: phrase("address") }}" value=""
                                        {{config("pages.form.validate.rules.address") ? "required" : ""}}
                                        name="address">{{config("pages.form.data.address")}}</textarea>

                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label" for="location">
                                {{ Translator:: phrase("location") }}
                                @if(config("pages.form.validate.rules.location"))
                                <span class="badge badge-md badge-circle badge-floating badge-danger"
                                    style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                                @endif

                            </label>

                            <div class="form-group">
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text map-marker" data-target="#location"><i
                                                class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input class="form-control" id="location"
                                        placeholder="{{ Translator:: phrase("location") }}"
                                        value="{{config("pages.form.data.location")}}"
                                        {{config("pages.form.validate.rules.location") ? "required" : ""}}
                                        name="location" />

                                </div>
                            </div>

                        </div>


                    </div>

                </div>

                <div class="col-md-4">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label class="form-control-label" for="profile">
                                {{ Translator:: phrase("photo") }}
                                @if(config("pages.form.validate.rules.profile"))
                                <span class="badge badge-md badge-circle badge-floating badge-danger"
                                    style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                                @endif
                            </label>
                            <div class="dropzone dropzone-single" data-toggle="dropzone"
                                data-dropzone-url="{{config("pages.form.data.profile")}}">
                                <div class="fallback">
                                    <div class="custom-file">
                                        <input type="file" placeholder="{{ Translator:: phrase("drop_photo_here") }}"
                                            class="custom-file-input" id="dropzoneBasicUpload" name="profile"
                                            {{config("pages.form.validate.rules.profile") ? "required" : ""}} />
                                        <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123"
                                            class="custom-file-label"
                                            for="dropzoneBasicUpload">{{ Translator:: phrase("choose.photo") }}</label>
                                    </div>
                                </div>

                                <div class="dz-preview dz-preview-single">
                                    <div class="dz-preview-cover">
                                        <img class="dz-preview-img"
                                            data-src="{{config("pages.form.data.profile")}}?type=original" alt
                                            data-dz-thumbnail>
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
</div>
