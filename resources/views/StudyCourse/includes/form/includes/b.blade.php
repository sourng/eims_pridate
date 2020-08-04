<div class="card">


    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            B
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label class="form-control-label" for="name">
                    {{ Translator:: phrase("study_course_name") }}

                    @if(array_key_exists("name",config("pages.form.validate.rules"))) <span
                        class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>
                <input type="text" class="form-control" name="name" id="name"
                    placeholder="{{ Translator::phrase("study_course_name") }}"
                    value="{{config("pages.form.data.name")}}"
                    {{(array_key_exists("name", config("pages.form.validate.rules"))) ? "required" : ""}} />

            </div>
        </div>

        <div class="form-row">
            @if (config('app.languages'))
            @foreach (config('app.languages') as $lang)
            <div class="col-md-6 mb-3">
                <label class="form-control-label" for="{{$lang["code_name"]}}">
                    {{ Translator:: phrase(str_replace("-","_",config("pages.form.name")).".as.".$lang["translate_name"]) }}

                    @if(array_key_exists($lang["code_name"],config("pages.form.validate.rules")))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>
                <input type="text" class="form-control" name="{{$lang["code_name"]}}" id="{{$lang["code_name"]}}"
                    placeholder="{{ Translator::phrase(str_replace("-","_",config("pages.form.name")).".as.".$lang["translate_name"]) }}"
                    value="{{config("pages.form.data.".$lang["code_name"])}}"
                    {{(array_key_exists($lang["code_name"], config("pages.form.validate.rules"))) ? "required" : ""}} />
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
