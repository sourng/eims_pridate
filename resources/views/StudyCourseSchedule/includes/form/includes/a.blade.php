<div class="card">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            A
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">
            @if (Auth::user()->role_id == 1)
            <div class="col-md-12 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.institute")}}" class="form-control-label"
                    for="institute">
                    {{ Translator:: phrase("institute") }}

                    @if(config("pages.form.validate.rules.institute"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
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
            <div class="col-md-4 mb-3">
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
                    data-select-value="{{config("pages.form.data.study_program.id")}}" data-append-to="#study_course"
                    data-append-url="{{str_replace("add","list?programId=",$study_course["pages"]["form"]["action"]["add"])}}">
                    @foreach($study_program["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                        {{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-control-label" for="study_course">
                    {{ Translator:: phrase("study_course") }}

                    @if(array_key_exists("study_course",config("pages.form.validate.rules")))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif
                </label>
                <select {{$study_course['success']? "" : "disabled" }} class="form-control"
                    data-toggle="select" id="study_course" title="Simple select"


                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.study_course") }}" name="study_course"
                    data-select-value="{{config("pages.form.data.study_course.id")}}">
                    @foreach($study_course["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label class="form-control-label" for="study_generation">
                    {{ Translator:: phrase("study_generation") }}

                    @if(array_key_exists("study_generation",config("pages.form.validate.rules")))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="study_generation" title="Simple select"


                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.study_generation") }}" name="study_generation"
                    data-select-value="{{config("pages.form.data.study_generation.id")}}">
                    @foreach($study_generation["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-control-label" for="academic_year">
                    {{ Translator:: phrase("study_academic_year") }}

                    @if(array_key_exists("academic_year",config("pages.form.validate.rules")))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="study_academic_year" title="Simple select"


                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.study_academic_year") }}" name="study_academic_year"
                    data-select-value="{{config("pages.form.data.study_academic_year.id")}}">
                    @foreach($study_academic_year["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-control-label" for="study_semester">
                    {{ Translator:: phrase("study_semester") }}

                    @if(array_key_exists("study_semester",config("pages.form.validate.rules")))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif
                </label>
                <select class="form-control" data-toggle="select" id="study_semester" title="Simple select"
                   

                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.study_semester") }}" name="study_semester"
                    data-select-value="{{config("pages.form.data.study_semester.id")}}">
                    @foreach($study_semester["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
