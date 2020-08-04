<div class="card">
    <div class="card-header p-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            (A)
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label class="form-control-label" for="study_course_session">
                    {{ Translator:: phrase("study_course_session") }}

                    @if(array_key_exists("study_course_session",config("pages.form.validate.rules")))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="study_course_session" title="Simple select"


                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.study_course_session") }}"
                    name="study_course_session"
                    data-select-value="{{config("pages.form.data.study_course_session.id")}}">
                    @foreach($study_course_session["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-8 mb-3">
                <label class="form-control-label" for="student">
                    {{ Translator:: phrase("student.request_study") }}

                    @if(array_key_exists("student[]",config("pages.form.validate.rules")))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select {{config("pages.form.role") == "add" ? "multiple" : ""}}  class="form-control" data-toggle="select" id="student" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.student") }}" name="student[]"
                    data-select-value="{{config("pages.form.data.request_id",request("studRequestId"))}}"

                    {{(array_key_exists("student[]",config("pages.form.validate.rules"))) ? "required" : ""}}>
                    @foreach($student["data"] as $o)
                    <option data-src="{{$o["photo"]}}" value="{{$o["id"]}}">
                        {{ $o["name"]}}</option>
                    @endforeach

                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.study_status")}}" class="form-control-label"
                    for="study_status">
                    {{ Translator:: phrase("study_status") }}

                    @if(config("pages.form.validate.rules.study_status"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>
                <select class="form-control" data-toggle="select" id="study_status" title="Simple select"
                    

                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.study_status") }}" name="study_status"
                    data-select-value="{{config("pages.form.data.study_status.id")}}">
                    @foreach($study_status["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
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
