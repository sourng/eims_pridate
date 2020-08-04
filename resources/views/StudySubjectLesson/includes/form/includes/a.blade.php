<div class="card">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            A
        </label>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-7">
                <div class="form-row">
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
                            title="{{config("pages.form.validate.questions.staff_teach_subject")}}"
                            class="form-control-label" for="staff_teach_subject">
                            {{ Translator:: phrase("staff_teach_subject") }}

                            @if(config("pages.form.validate.rules.staff_teach_subject"))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset">
                                <i class="fas fa-asterisk fa-xs"></i>
                            </span>
                            @endif
                        </label>

                        <select class="form-control" data-toggle="select" id="staff_teach_subject" title="Simple select"
                            

                            data-text="{{ Translator::phrase("add_new_option") }}"
                            data-placeholder="{{ Translator::phrase("choose.staff_teach_subject") }}" name="staff_teach_subject"
                            data-select-value="{{config("pages.form.data.staff_teach_subject.id")}}"
                            {{config("pages.form.validate.rules.staff_teach_subject") ? "required" : ""}}>
                            @foreach($staff_teach_subject["data"] as $o)
                            <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="title">
                            {{ Translator:: phrase("title") }}

                            @if(config("pages.form.validate.rules.title")) <span
                                class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>
                        <input type="text" class="form-control" name="title" id="title"
                            placeholder="{{ Translator::phrase("title") }}" value="{{config("pages.form.data.title")}}"
                            {{config("pages.form.validate.rules.title") ? "required" : ""}} />

                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                            title="{{config("pages.form.validate.questions.source_file")}}" class="form-control-label"
                            for="source_file">
                            {{ Translator:: phrase("File.(.PDF.)") }}

                            @if (config("pages.form.role") == "add")
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset">
                                <i class="fas fa-asterisk fa-xs"></i>
                            </span>
                            @endif
                        </label>
                        <input type="file" data-toggle="read-pdf" accept="application/pdf" data-target=".dz-preview-img"
                            class="form-control" id="source_file" name="source_file" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div id="read-pdf">


                        @if(config("pages.form.data.source_file"))
                        <iframe src="{{config("pages.form.data.source_file")}}" frameborder="0" scrolling="no"
                            class="w-100" height="300"></iframe>
                        @endif
                    </div>

                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="link">
                            {{ Translator:: phrase("link") }}
                        </label>
                        <hr class="my-2">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="list-group">
                                    <a class="list-group-item list-group-item-action rounded-0 active" id="youtube-tab"
                                        data-toggle="tab" href="#youtube" role="tab" aria-controls="youtube"
                                        aria-selected="true">
                                        {{ Translator:: phrase("youtube") }}
                                    </a>
                                    <a class="list-group-item list-group-item-action rounded-0" id="facebook-tab"
                                        data-toggle="tab" href="#facebook" role="tab" aria-controls="facebook"
                                        aria-selected="true">
                                        {{ Translator:: phrase("facebook") }}
                                    </a>

                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="tab-content border-0 bg-neutral px-0" id="myTabContent">
                                    <div id="youtube" class="tab-pane fade show active" role="tabpanel"
                                        aria-labelledby="youtube-tab">
                                        <input type="link" placeholder="{{ Translator:: phrase("youtube") }}"
                                            class="form-control" id="source_link_youtube" name="source_link_youtube"
                                            value="{{config("pages.form.data.source_link.youtube.url")}}"
                                            {{config("pages.form.validate.rules.source_link_youtube") ? "required" : ""}}>
                                    </div>
                                    <div id="facebook" class="tab-pane fade" role="tabpanel"
                                        aria-labelledby="facebook-tab">
                                        <input type="link" placeholder="{{ Translator:: phrase("facebook") }}"
                                            class="form-control" id="source_link_facebook" name="source_link_facebook"
                                            value="{{config("pages.form.data.source_link.facebook.url")}}"
                                            {{config("pages.form.validate.rules.source_link_facebook") ? "required" : ""}}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="image">
                            {{ Translator:: phrase("image") }}
                            @if(config("pages.form.validate.rules.image"))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
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
                                    <img class="dz-preview-img"
                                        data-src="{{config("pages.form.data.image")}}?type=original" alt
                                        data-dz-thumbnail>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
</div>
