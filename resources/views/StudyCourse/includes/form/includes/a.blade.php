<div class="card">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            A
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">
            @if (request()->segment(3) == "view")
            <div class="col-md-6 mb-3">
                <label class="form-control-label" for="id">
                    {{ Translator:: phrase("numbering") }}
                </label>
                <span class="form-control" id="id" type="hidden" name="id"
                    value="{{config("pages.form.data.id")}}">{{config("pages.form.data.id")}}</span>
            </div>
            @endif
        </div>
        <div class="form-row">
            @if (Auth::user()->role_id == 1)
            <div class="col-md-12 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.institute")}}" class="form-control-label"
                    for="institute">
                    {{ Translator:: phrase("institute") }}

                    @if(config("pages.form.validate.rules.institute"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger"
                        style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>

                <select class="form-control" data-toggle="select" id="institute" title="Simple select"


                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.institute") }}" name="institute"
                    data-select-value="{{config("pages.form.data.institute.id")}}"
                    {{config("pages.form.validate.rules.institute") ? "required" : ""}}>
                    @foreach($institute["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>
            @else
            <input type="hidden" name="institute" id="institute" value="{{Auth::user()->institute_id}}">
            @endif
        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label class="form-control-label" for="study_program">
                    {{ Translator:: phrase("study_program") }}

                    @if(array_key_exists("study_program",config("pages.form.validate.rules")))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="study_program" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.study_program") }}" name="study_program"
                    data-select-value="{{config("pages.form.data.study_program.id")}}"
                    {{(array_key_exists("study_program",config("pages.form.validate.rules"))) ? "required" : ""}}>
                    @foreach($study_program["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach

                </select>
            </div>

            {{-- <div class="col-md-3 mb-3">
                <label class="form-control-label" for="course_type">
                    {{ Translator:: phrase("course_type") }}

                    @if(array_key_exists("course_type",config("pages.form.validate.rules")))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="course_type" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.course_type") }}" name="course_type"
                    data-select-value="{{config("pages.form.data.course_type.id")}}"
                    {{(array_key_exists("course_type",config("pages.form.validate.rules"))) ? "required" : ""}}>
                    @foreach($course_type["data"] as $o)
                    <option value="{{$o["id"]}}">{{ $o["name"]}}
                    @endforeach

                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-control-label" for="study_modality">
                    {{ Translator:: phrase("study_modality") }}

                    @if(array_key_exists("study_modality",config("pages.form.validate.rules")))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="study_modality" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.study_modality") }}" name="study_modality"
                    data-select-value="{{config("pages.form.data.study_modality.id")}}"
                    {{(array_key_exists("study_modality",config("pages.form.validate.rules"))) ? "required" : ""}}>
                    @foreach($study_modality["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}
                    @endforeach

                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-control-label" for="study_faculty">
                    {{ Translator:: phrase("study_faculty") }}

                    @if(array_key_exists("study_faculty",config("pages.form.validate.rules")))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="study_faculty" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.study_faculty") }}" name="study_faculty"
                    data-select-value="{{config("pages.form.data.study_faculty.id")}}"
                    {{(array_key_exists("study_faculty",config("pages.form.validate.rules"))) ? "required" : ""}}>
                    @foreach($study_faculty["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}
                    @endforeach

                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-control-label" for="study_overall_fund">
                    {{ Translator:: phrase("study_overall_fund") }}

                    @if(array_key_exists("study_overall_fund",config("pages.form.validate.rules")))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="study_overall_fund" title="Simple select"
                   
                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.study_overall_fund") }}" name="study_overall_fund"
                    data-select-value="{{config("pages.form.data.study_overall_fund.id")}}"
                    {{(array_key_exists("study_overall_fund",config("pages.form.validate.rules"))) ? "required" : ""}}>
                    @foreach($study_overall_fund["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}
                    @endforeach

                </select>
            </div> --}}
        </div>


    </div>
</div>
