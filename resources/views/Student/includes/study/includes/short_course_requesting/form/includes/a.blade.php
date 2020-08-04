<div class="card">
    <div class="card-header p-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            (A) {{ Translator:: phrase("institute_info") }}
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">
        <input type="hidden" name="id" value="{{config("pages.form.data.id")}}">
        </div>
        <div class="form-row">

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

                    data-placeholder="{{ Translator::phrase("choose.institute") }}" name="institute"
                    data-select-value="{{config("pages.form.data.institute.id",Auth::user()->institute_id)}}"
                    {{config("pages.form.validate.rules.institute") ? "required" : ""}}>
                    @foreach($institute["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.study_subject")}}" class="form-control-label"
                    for="study_subject">

                    {{ Translator:: phrase("study_subject") }}

                    @if(config("pages.form.validate.rules.study_subject"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>
                <select class="form-control" data-toggle="select" id="study_subject" title="Simple select"

                    data-placeholder="{{ Translator::phrase("choose.study_subject") }}" name="study_subject"
                    data-select-value="{{config("pages.form.data.study_subject.id",request("semesterId"))}}">
                    @foreach($study_subject["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.study_session")}}" class="form-control-label"
                    for="study_session">

                    {{ Translator:: phrase("study_session") }}

                    @if(config("pages.form.validate.rules.study_session"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>
                <select class="form-control" data-toggle="select" id="study_session" title="Simple select"

                    data-placeholder="{{ Translator::phrase("choose.study_session") }}" name="study_session"
                    data-select-value="{{config("pages.form.data.study_session.id",request("sessionId"))}}">
                    @foreach($study_session["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
</div>
