<div class="card">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            C
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.attendance_marks")}}" class="form-control-label"
                    for="attendance_marks">
                    {{Translator::phrase("attendance_marks")}}
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                </label>
                <input type="number" class="form-control" name="attendance_marks"
                    id="attendance_marks" placeholder="{{Translator::phrase("attendance_marks")}}"
                    value="{{config("pages.form.data.scores.attendance_marks.marks")}}"
                    {{config("pages.form.validate.rules.attendance_marks") ? "required" : ""}} />
            </div>

            <div class="col-md-4 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.other_marks")}}" class="form-control-label"
                    for="other_marks">
                    {{Translator::phrase("other_marks")}}
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                </label>
                <input type="number" class="form-control" name="other_marks"
                    id="other_marks" placeholder="{{Translator::phrase("other_marks")}}"
                    value="{{config("pages.form.data.scores.other_marks.marks")}}"
                    {{config("pages.form.validate.rules.other_marks") ? "required" : ""}} />
            </div>
        </div>
    </div>
</div>
