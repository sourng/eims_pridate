<div class="card m-0">
    <div class="card-header p-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            (D) {{ Translator:: phrase("qualiftion") }}
        </label>
    </div>

    <div class="card-body">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123" class="form-control-label"
                    for="staff_exam">
                    {{ Translator:: phrase("staff_exam") }}

                    @if(config("pages.form.validate.rules.staff_exam"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif
                </label>

                <select class="form-control" data-toggle="select" id="staff_certificate" title="Simple select"
                   

                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.staff_certificate") }}" name="staff_certificate"
                    data-select-value="{{config("pages.form.data.staff_qualification.certificate.id")}}"
                    {{config("pages.form.validate.rules.staff_certificate") ? "required" : ""}}>
                    @foreach($staff_certificate["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="mb-3 p-3 border rounded" id="taget_experience">
            @if(config("pages.form.data.staff_experience"))
            @foreach (config("pages.form.data.staff_experience") as $experience)
            <div class="form-row" data-clone="_experience">
                <div class="col-md-4 mb-3">
                    <input class="form-control" title="{{ Translator::phrase("experience") }}"
                        placeholder="{{ Translator::phrase("experience") }}"
                        id="experience" name="experience[id-{{$experience["id"]}}]"
                        {{config("pages.form.validate.rules.experience") ? "required" : ""}} value="{{$experience["experience"]}}"/>
                </div>
                <div class="col-md-5 mb-3">
                    <textarea class="form-control" title="{{ Translator::phrase("experience_info") }}"
                        placeholder="{{ Translator::phrase("experience_info") }}" id="experience_info"
                        name="experience_info[id-{{$experience["id"]}}]"
                {{config("pages.form.validate.rules.experience") ? "required" : ""}}>{{$experience["experience_info"]}}</textarea>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="#"  data-name="experience[],experience_info[]" data-target-change="#experience,#experience_info" data-toggle="clone" data-clone-from="_experience"  data-clone-target="taget_experience"  class="btn btn-default"><i class="fas fa-plus"></i></a>
                    <a href="#" data-clone-delete="_experience" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                </div>
            </div>
            @endforeach
            @else
            <div class="form-row" data-clone="_experience">
                <div class="col-md-4 mb-3">
                    <input class="form-control" title="{{ Translator::phrase("experience") }}"
                        placeholder="{{ Translator::phrase("experience") }}"
                        id="experience" name="experience[]"
                        {{config("pages.form.validate.rules.experience") ? "required" : ""}} value=""/>
                </div>
                <div class="col-md-5 mb-3">
                    <textarea class="form-control" title="{{ Translator::phrase("experience_info") }}"
                        placeholder="{{ Translator::phrase("experience_info") }}" id="experience_info"
                        name="experience_info[]"
                {{config("pages.form.validate.rules.experience") ? "required" : ""}}></textarea>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="#" data-toggle="clone" data-clone-from="_experience"  data-clone-target="taget_experience"  class="btn btn-default btn-sm"><i class="fas fa-plus"></i></a>
                    <a href="#" data-clone-delete="_experience" class="btn btn-danger btn-sm invisible"><i class="fas fa-trash"></i></a>
                </div>
            </div>
            @endif

        </div>


        <a class="badge badge-warning" data-toggle="collapse" href="#other_experience" role="button"
            aria-expanded="false" aria-controls="other_experience">{{ Translator:: phrase("other") }}</a>

        <div class="collapse" id="other_experience">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123"
                        class="form-control-label mt-3" for="staff_certificate_info">
                        {{ Translator:: phrase("other_info") }}

                        @if(config("pages.form.validate.rules.staff_certificate_info"))
                        <span class="badge badge-md badge-circle badge-floating badge-danger"
                            style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                        @endif
                    </label>
                    <div class="form-group">
                        <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-info"></i></span>
                            </div>
                            <textarea class="form-control" title="{{ Translator::phrase("other_info") }}"
                                placeholder="{{ Translator::phrase("other_info") }}" id="staff_certificate_info"
                                name="staff_certificate_info"
                                {{config("pages.form.validate.rules.staff_certificate_info") ? "required" : ""}}>{{config("pages.form.data.staff_qualification.extra_info")}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
