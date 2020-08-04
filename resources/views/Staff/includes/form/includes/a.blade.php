<div class="card">
    <div class="card-header p-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            (A) {{ Translator:: phrase("institute_info") }}
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">

            @if (Auth::user()->institute_id)
            <input type="hidden" name="institute" value="{{Auth::user()->institute_id}}">
            @else
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
                    data-select-value="{{config("pages.form.data.staff_institute.institute.id")}}"
                    {{config("pages.form.validate.rules.institute") ? "required" : ""}}>
                    @foreach($institute["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.designation")}}" class="form-control-label"
                    for="designation">

                    {{ Translator:: phrase("designation") }}

                    @if(config("pages.form.validate.rules.designation"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>

                <select class="form-control" data-toggle="select" id="designation" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}" data-allow-clear="true"
                    data-select-value="{{config("pages.form.data.staff_institute.designation.id")}}"
                    data-placeholder="{{ Translator::phrase("choose.designation") }}" name="designation">

                    @foreach($designation["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                        {{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.status")}}" class="form-control-label"
                    for="status">
                    {{ Translator:: phrase("status") }}
                    @if(config("pages.form.validate.rules.status"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>

                <select class="form-control" data-toggle="select" id="status" title="Simple select"
                   

                    data-text="{{ Translator::phrase("add_new_option") }}" data-allow-clear="true"
                    data-select-value="{{config("pages.form.data.staff_status.id")}}"
                    data-placeholder="{{ Translator::phrase("choose.status") }}" name="status">
                    @foreach($status["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                        {{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>




            <div class="col-md-12 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.extra_info")}}" class="form-control-label"
                    for="institute_extra_info">
                    {{ Translator:: phrase("extra_info") }}
                    @if(config("pages.form.validate.rules.institute_extra_info"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span> @endif
                </label>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info"></i></span>
                        </div>
                        <textarea type="text" class="form-control" id="institute_extra_info"
                            placeholder="{{ Translator:: phrase("extra_info") }}" value=""
                            {{config("pages.form.validate.rules.institute_extra_info") ? "required" : ""}}
                            name="institute_extra_info">{{config("pages.form.data.staff_institute.extra_info")}}</textarea>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
