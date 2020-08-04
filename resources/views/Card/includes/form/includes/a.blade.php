<div class="card m-0">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            A
        </label>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
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
                        <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                            title="{{(array_key_exists("institute",config("pages.form.validate.questions"))) ?config("pages.form.validate.questions")["institute"] : ""}}"
                            class="form-control-label" for="institute">
                            {{ Translator:: phrase("institute") }}
                            @if(array_key_exists("institute",config("pages.form.validate.rules"))) <span
                                class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span> @endif
                        </label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-school"></i></span>
                                </div>
                                <select class="form-control" data-toggle="select" id="institute" title="Simple select"
                                    data-minimum-results-for-search="Infinity"
                                    data-placeholder="{{ Translator::phrase("institute") }}" name="institute"
                                    data-select-value="{{config("pages.form.data.institute.id")}}"
                                    {{(array_key_exists("institute", config("pages.form.validate.rules"))) ? "required" : ""}}>

                                    @foreach($institutes["data"] as $o)
                                    <option value="{{$o["id"]}}">{{ $o["name"]}}
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                            title="{{(array_key_exists("type",config("pages.form.validate.questions"))) ?config("pages.form.validate.questions")["type"] : ""}}"
                            class="form-control-label" for="type">
                            {{ Translator:: phrase("type") }}
                            @if(array_key_exists("type",config("pages.form.validate.rules"))) <span
                                class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif
                        </label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-columns"></i></span>
                                </div>
                                <select class="form-control" data-toggle="select" id="type" title="Simple select"
                                    data-minimum-results-for-search="Infinity"
                                    data-placeholder="{{ Translator::phrase("choose.type") }}" name="type"
                                    data-select-value="{{config("pages.form.data.type")}}">
                                    <option value="student">
                                        {{ Translator::phrase("student")}}
                                    </option>
                                    <option value="teacher">
                                        {{ Translator::phrase("teacher")}}
                                    </option>
                                    <option value="staff">
                                        {{ Translator::phrase("staff")}}
                                    </option>
                                    <option value="other">
                                        {{ Translator::phrase("other")}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                            title="{{(array_key_exists("layout",config("pages.form.validate.questions"))) ?config("pages.form.validate.questions")["layout"] : ""}}"
                            class="form-control-label" for="layout">
                            {{ Translator:: phrase("layout") }}
                            @if(array_key_exists("layout",config("pages.form.validate.rules"))) <span
                                class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif
                        </label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-columns"></i></span>
                                </div>
                                <select class="form-control" data-change-text="frame_front,frame_background"
                                    data-toggle="select" id="layout" title="Simple select"
                                    data-minimum-results-for-search="Infinity"
                                    data-placeholder="{{ Translator::phrase("choose.layout") }}" name="layout"
                                    data-select-value="{{config("pages.form.data.layout")}}">
                                    <option data-text="(250x350 pixels)" value="vertical">
                                        {{ Translator::phrase("vertical")}}
                                    </option>
                                    <option data-text="(350x250 pixels)" value="horizontal">
                                        {{ Translator::phrase("horizontal")}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                            title="{{(array_key_exists("name",config("pages.form.validate.questions"))) ?config("pages.form.validate.questions")["name"] : ""}}"
                            class="form-control-label" for="name">
                            {{ Translator:: phrase("name") }}
                            @if(array_key_exists("name",config("pages.form.validate.rules"))) <span
                                class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif
                        </label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fad fa-address-card"></i></span>
                                </div>
                                <input class="form-control" id="name" placeholder="{{ Translator::phrase("name") }}"
                                    name="name" value="{{config("pages.form.data.name")}}">
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label data-toggle="tooltip" for="front" class="form-control-label">
                            {{ Translator:: phrase("frame_front") }}
                            <span data-change-text-id="frame_front"></span>
                            @if(array_key_exists("front",config("pages.form.validate.rules")))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>
                        <div class="dropzone dropzone-single" data-toggle="dropzone"
                            data-dropzone-url="{{config("pages.form.data.front")}}">
                            <div class="fallback">
                                <div class="custom-file">
                                    <input type="file" placeholder="{{ Translator:: phrase("drop_image_here") }}"
                                        class="custom-file-input" id="dropzoneBasicUpload" name="front"
                                        {{(array_key_exists("front", config("pages.form.validate.rules"))) ? "required" : ""}} />
                                    <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123"
                                        class="custom-file-label"
                                        for="dropzoneBasicUpload">{{ Translator:: phrase("choose.image") }}</label>
                                </div>
                            </div>

                            <div class="dz-preview dz-preview-single">
                                <div class="dz-preview-cover">
                                    <img class="dz-preview-img" data-src="{{config("pages.form.data.front")}}"
                                        alt data-dz-thumbnail>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <label data-toggle="tooltip" for="background" class="form-control-label">
                            {{ Translator:: phrase("frame_background") }}
                            <span data-change-text-id="frame_background"></span>
                            @if(array_key_exists("background",config("pages.form.validate.rules")))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif
                        </label>

                        <div class="dropzone dropzone-single" data-toggle="dropzone"
                            data-dropzone-url="{{config("pages.form.data.background")}}">
                            <div class="fallback">
                                <div class="custom-file">
                                    <input type="file" placeholder="{{ Translator:: phrase("drop_image_here") }}"
                                        class="custom-file-input" id="dropzoneBasicUpload" name="background"
                                        {{(array_key_exists("background", config("pages.form.validate.rules"))) ? "required" : ""}} />
                                    <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123"
                                        class="custom-file-label"
                                        for="dropzoneBasicUpload">{{ Translator:: phrase("choose.image") }}</label>
                                </div>
                            </div>

                            <div class="dz-preview dz-preview-single">
                                <div class="dz-preview-cover">
                                    <img class="dz-preview-img"
                                        data-src="{{config("pages.form.data.background")}}" alt
                                        data-dz-thumbnail>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                        <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                            title="{{(array_key_exists("description",config("pages.form.validate.questions"))) ?config("pages.form.validate.questions")["description"] : ""}}"
                            class="form-control-label " for="description">

                            {{ Translator:: phrase("description") }}

                            @if(array_key_exists("description",config("pages.form.validate.rules")))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-info"></i></span>
                                </div>
                                <textarea type="text" class="form-control" name="description" id="description"
                                    placeholder="{{ Translator::phrase("description") }}"
                                    {{(array_key_exists("description", config("pages.form.validate.rules"))) ? "required" : ""}}>{{config("pages.form.data.description")}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
