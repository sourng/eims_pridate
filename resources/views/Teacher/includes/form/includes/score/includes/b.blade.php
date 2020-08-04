<div class="card">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            B {{Translator::phrase("study_subject")}}
        </label>
    </div>
    <div class="card-body">
        @if (config("pages.form.data.scores"))
        <div class="form-row">
            @foreach (config("pages.form.data.scores") as $key => $score)
            @if ($key !== "attendance_marks" && $key !== "other_marks")

            <div class="col-md-4 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.study_subject[]")}}" class="form-control-label"
                    for="study_subject-{{$key}}">
                    {{$score["study_subject"]["name"]}}
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                </label>
                <input type="number" class="form-control" name="study_subject[{{$key}}]" id="study_subject-{{$key}}"
                    placeholder="{{$score["study_subject"]["name"]}}" value="{{$score["marks"]}}"
                    {{config("pages.form.validate.rules.study_subject[]") ? "required" : ""}} />
            </div>
            @endif
            @endforeach
        </div>
        @endif

    </div>
</div>
