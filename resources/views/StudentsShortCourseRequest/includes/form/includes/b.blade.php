<div class="card m-0">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            B
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.student")}}" class="form-control-label"
                    for="student">

                    {{ Translator:: phrase("student") }}

                    @if(config("pages.form.validate.rules.student[]"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>
                <select multiple class="form-control" data-toggle="select" id="student" title="Simple select"
                    data-placeholder="{{ Translator::phrase("choose.student") }}" name="student[]"
                    data-select-value="{{config("pages.form.data.student.id",request("sessionId"))}}">
                    @foreach($student["data"] as $o)
                    <option data-src="{{$o["photo"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
