<div class="card">
    <div class="card-header p-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            {{ Translator:: phrase("father_info") }}
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.father_fullname")}}" class="form-control-label"
                    for="father_fullname">

                    {{ Translator:: phrase("father_fullname") }}
                    @if(config("pages.form.validate.rules.father_fullname"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        </div>
                        <input type="text" class="form-control" id="father_fullname"
                            placeholder="{{ Translator::phrase("father_fullname") }}"
                            value="{{config("pages.form.data.staff_guardian.father.name")}}"
                            {{config("pages.form.validate.rules.father_fullname") ? "required" : ""}}
                            name="father_fullname" />

                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.father_occupation")}}" class="form-control-label"
                    for="father_occupation">

                    {{ Translator:: phrase("occupation") }}
                    @if(config("pages.form.validate.rules.father_occupation"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        </div>
                        <input type="text" class="form-control" id="father_occupation"
                            placeholder="{{ Translator::phrase("occupation") }}"
                            value="{{config("pages.form.data.staff_guardian.father.occupation")}}"
                            {{config("pages.form.validate.rules.father_occupation") ? "required" : ""}}
                            name="father_occupation" />

                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.father_phone")}}" class="form-control-label"
                    for="father_phone">

                    {{ Translator:: phrase("father_phone") }}
                    @if(config("pages.form.validate.rules.father_phone"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif

                </label>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" class="form-control" id="father_phone"
                            placeholder="{{ Translator:: phrase("father_phone") }}"
                            value="{{config("pages.form.data.staff_guardian.father.phone")}}"
                            {{config("pages.form.validate.rules.father_phone") ? "required" : ""}}
                            name="father_phone" />


                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.father_email")}}" class="form-control-label"
                    for="father_phone">

                    {{ Translator:: phrase("father_email") }}
                    @if(config("pages.form.validate.rules.father_email"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif

                </label>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="text" class="form-control" id="father_email"
                            placeholder="{{ Translator:: phrase("father_email") }}"
                            value="{{config("pages.form.data.staff_guardian.father.email")}}"
                            {{config("pages.form.validate.rules.father_email") ? "required" : ""}}
                            name="father_email" />


                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.father_extra_info")}}" class="form-control-label "
                    for="father_extra_info">

                    {{ Translator:: phrase("extra_info") }}

                    @if(config("pages.form.validate.rules.father_extra_info")) <span
                        class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif

                </label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info"></i></span>
                        </div>
                        <textarea type="text" class="form-control" name="father_extra_info" id="father_extra_info"
                            placeholder="{{ Translator::phrase("extra_info") }}"
                            {{config("pages.form.validate.rules.father_extra_info") ? "required" : ""}}>{{config("pages.form.data.staff_guardian.father.extra_info")}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header p-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            {{ Translator:: phrase("mother_info") }}
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.mother_fullname")}}" class="form-control-label"
                    for="mother_fullname">

                    {{ Translator:: phrase("mother_fullname") }}
                    @if(config("pages.form.validate.rules.mother_fullname"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        </div>
                        <input type="text" class="form-control" id="mother_fullname"
                            placeholder="{{ Translator::phrase("mother_fullname") }}"
                            value="{{config("pages.form.data.staff_guardian.mother.name")}}"
                            {{config("pages.form.validate.rules.mother_fullname") ? "required" : ""}}
                            name="mother_fullname" />

                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.mother_occupation")}}" class="form-control-label"
                    for="mother_occupation">

                    {{ Translator:: phrase("occupation") }}
                    @if(config("pages.form.validate.rules.mother_occupation"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        </div>
                        <input type="text" class="form-control" id="mother_occupation"
                            placeholder="{{ Translator::phrase("occupation") }}"
                            value="{{config("pages.form.data.staff_guardian.mother.occupation")}}"
                            {{config("pages.form.validate.rules.mother_occupation") ? "required" : ""}}
                            name="mother_occupation" />

                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.mother_phone")}}" class="form-control-label"
                    for="mother_phone">

                    {{ Translator:: phrase("mother_phone") }}
                    @if(config("pages.form.validate.rules.mother_phone"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif

                </label>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" class="form-control" id="mother_phone"
                            placeholder="{{ Translator:: phrase("mother_phone") }}"
                            value="{{config("pages.form.data.staff_guardian.mother.phone")}}"
                            {{config("pages.form.validate.rules.mother_phone") ? "required" : ""}}
                            name="mother_phone" />


                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.mother_email")}}" class="form-control-label"
                    for="mother_phone">

                    {{ Translator:: phrase("mother_email") }}
                    @if(config("pages.form.validate.rules.mother_email"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif

                </label>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="text" class="form-control" id="mother_email"
                            placeholder="{{ Translator:: phrase("mother_email") }}"
                            value="{{config("pages.form.data.staff_guardian.mother.email")}}"
                            {{config("pages.form.validate.rules.mother_email") ? "required" : ""}}
                            name="mother_email" />


                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                    title="{{config("pages.form.validate.questions.mother_extra_info")}}" class="form-control-label "
                    for="mother_extra_info">

                    {{ Translator:: phrase("extra_info") }}

                    @if(config("pages.form.validate.rules.mother_extra_info")) <span
                        class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif

                </label>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info"></i></span>
                        </div>
                        <textarea type="text" class="form-control" name="mother_extra_info" id="mother_extra_info"
                            placeholder="{{ Translator::phrase("extra_info") }}"
                            {{config("pages.form.validate.rules.mother_extra_info") ? "required" : ""}}>{{config("pages.form.data.staff_guardian.mother.extra_info")}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header p-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            (C) {{ Translator:: phrase("guardian") }}
        </label>
        @if(config("pages.form.validate.rules.guardian"))
        <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
            <i class="fas fa-asterisk fa-xs"></i>
        </span>
        @endif
    </div>
    <div class="card-header p-2 px-4">
        <div class="form-group form-control col" id="guardian">
            @if (config('pages.parameters.param1') == "view")
                @if(config("pages.form.data.staff_guardian.guardian_is") == "father")
                    <div class="custom-control custom-radio custom-control-inline col-4">
                        <input {{config("pages.form.data.staff_guardian.guardian_is") == "father" ? "checked" : ""}} data-toggle="radio" type="radio" data-hide-collapse="xguardian" id="father_is_guardian"
                            name="guardian" value="father" class="custom-control-input">
                        <label class="custom-control-label" for="father_is_guardian">
                            <span class="d-none d-sm-block">{{Translator::phrase("father_is_guardian")}}</span>
                            <span class="d-lg-none">{{Translator::phrase("father")}}</span>
                        </label>
                    </div>
                @elseif(config("pages.form.data.staff_guardian.guardian_is") == "mother")
                    <div class="custom-control custom-radio custom-control-inline col-4">
                        <input {{config("pages.form.data.staff_guardian.guardian_is") == "mother" ? "checked" : ""}} data-toggle="radio" type="radio" data-hide-collapse="xguardian" id="mother_is_guardian"
                            name="guardian" value="mother" class="custom-control-input">
                        <label class="custom-control-label" for="mother_is_guardian">
                            <span class="d-none d-sm-block">{{Translator::phrase("mother_is_guardian")}}</span>
                            <span class="d-lg-none">{{Translator::phrase("mother")}}</span>
                        </label>
                    </div>
                @else
                    <div  class="custom-control custom-radio custom-control-inline col-4">
                        <input {{config("pages.form.data.staff_guardian.guardian_is") !== "father" && config("pages.form.data.staff_guardian.guardian_is") !== "mother"  ? "checked" : ""}} data-toggle="radio" type="radio" data-show-collapse="xguardian" id="other_guardian"
                            name="guardian" value="other" class="custom-control-input">
                        <label class="custom-control-label" for="other_guardian"><span>{{Translator::phrase("other")}}</span>
                        </label>
                    </div>
                @endif
            @else
                <div class="custom-control custom-radio custom-control-inline col-4">
                    <input {{config("pages.form.data.staff_guardian.guardian_is") == "father" ? "checked" : ""}} data-toggle="radio" type="radio" data-hide-collapse="xguardian" id="father_is_guardian"
                        name="guardian" value="father" class="custom-control-input">
                    <label class="custom-control-label" for="father_is_guardian">
                        <span class="d-none d-sm-block">{{Translator::phrase("father_is_guardian")}}</span>
                        <span class="d-lg-none">{{Translator::phrase("father")}}</span>
                    </label>
                </div>
                <div class="custom-control custom-radio custom-control-inline col-4">
                    <input {{config("pages.form.data.staff_guardian.guardian_is") == "mother" ? "checked" : ""}} data-toggle="radio" type="radio" data-hide-collapse="xguardian" id="mother_is_guardian"
                        name="guardian" value="mother" class="custom-control-input">
                    <label class="custom-control-label" for="mother_is_guardian">
                        <span class="d-none d-sm-block">{{Translator::phrase("mother_is_guardian")}}</span>
                        <span class="d-lg-none">{{Translator::phrase("mother")}}</span>
                    </label>
                </div>
                <div  class="custom-control custom-radio custom-control-inline col-4">
                    <input {{config("pages.form.data.staff_guardian.guardian_is") !== "father" && config("pages.form.data.staff_guardian.guardian_is") !== "mother"  ? "checked" : ""}} data-toggle="radio" type="radio" data-show-collapse="xguardian" id="other_guardian"
                        name="guardian" value="other_guardian" class="custom-control-input">
                    <label class="custom-control-label" for="other_guardian"><span>{{Translator::phrase("other")}}</span>
                    </label>
                </div>

            @endif

        </div>
    </div>
    <div class="card-body">
        <div class="collapse {{config("pages.form.data.staff_guardian.guardian_is") !== "father" && config("pages.form.data.staff_guardian.guardian_is") !== "mother"  ? "show" : ""}}" id="xguardian">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="{{config("pages.form.validate.questions.guardian_fullname")}}" class="form-control-label"
                        for="guardian_fullname">

                        {{ Translator:: phrase("guardian_fullname") }}
                        @if(config("pages.form.validate.rules.guardian_fullname"))
                        <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                            <i class="fas fa-asterisk fa-xs"></i>
                        </span>
                        @endif
                    </label>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                            </div>
                            <input type="text" class="form-control" id="guardian_fullname"
                                placeholder="{{ Translator::phrase("guardian_fullname") }}"
                                value="{{config("pages.form.data.staff_guardian.guardian.name")}}"
                                {{config("pages.form.validate.rules.guardian_fullname") ? "required" : ""}}
                                name="guardian_fullname" />

                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="{{config("pages.form.validate.questions.guardian_occupation")}}"
                        class="form-control-label" for="guardian_occupation">

                        {{ Translator:: phrase("occupation") }}
                        @if(config("pages.form.validate.rules.guardian_occupation"))
                        <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                            <i class="fas fa-asterisk fa-xs"></i>
                        </span>
                        @endif
                    </label>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                            </div>
                            <input type="text" class="form-control" id="guardian_occupation"
                                placeholder="{{ Translator::phrase("occupation") }}"
                                value="{{config("pages.form.data.staff_guardian.guardian.occupation")}}"
                                {{config("pages.form.validate.rules.guardian_occupation") ? "required" : ""}}
                                name="guardian_occupation" />

                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="{{config("pages.form.validate.questions.guardian_phone")}}" class="form-control-label"
                        for="guardian_phone">

                        {{ Translator:: phrase("guardian_phone") }}
                        @if(config("pages.form.validate.rules.guardian_phone"))
                        <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                            <i class="fas fa-asterisk fa-xs"></i>
                        </span>
                        @endif

                    </label>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" id="guardian_phone"
                                placeholder="{{ Translator:: phrase("guardian_phone") }}"
                                value="{{config("pages.form.data.staff_guardian.guardian.phone")}}"
                                {{config("pages.form.validate.rules.guardian_phone") ? "required" : ""}}
                                name="guardian_phone" />


                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="{{config("pages.form.validate.questions.guardian_email")}}" class="form-control-label"
                        for="guardian_email">

                        {{ Translator:: phrase("guardian_email") }}
                        @if(config("pages.form.validate.rules.guardian_email"))
                        <span class="badge badge-md badge-circle badge-floating badge-danger"
                            style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span> @endif

                    </label>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="text" class="form-control" id="guardian_email"
                                placeholder="{{ Translator:: phrase("guardian_email") }}"
                                value="{{config("pages.form.data.staff_guardian.guardian.email")}}"
                                {{config("pages.form.validate.rules.guardian_email") ? "required" : ""}}
                                name="guardian_email" />


                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="{{config("pages.form.validate.questions.guardian_extra_info")}}"
                        class="form-control-label " for="guardian_extra_info">

                        {{ Translator:: phrase("extra_info") }}

                        @if(config("pages.form.validate.rules.guardian_extra_info"))
                        <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                            <i class="fas fa-asterisk fa-xs"></i>
                        </span>
                        @endif

                    </label>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-info"></i></span>
                            </div>
                            <textarea type="text" class="form-control" name="guardian_extra_info"
                                id="guardian_extra_info" placeholder="{{ Translator::phrase("extra_info") }}"
                                {{config("pages.form.validate.rules.guardian_extra_info") ? "required" : ""}}>{{config("pages.form.data.staff_guardian.guardian.extra_info")}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
