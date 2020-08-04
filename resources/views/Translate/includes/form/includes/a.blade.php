<div class="card m-0">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            A
        </label>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-row">
                    @csrf
                    @if (request()->segment(3) == "view")
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="id">
                            {{ Translator:: phrase("numbering") }}
                        </label>
                        <span class="form-control" id="id" name="id"
                            value="{{config("pages.form.data.id")}}">{{config("pages.form.data.id")}}</span>
                    </div>
                    @endif
                </div>


                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="phrase">
                            {{ Translator:: phrase("phrase") }}

                            @if(config("pages.form.validate.rules.phrase")) <span
                                class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>
                        <input type="text" class="form-control" name="phrase" id="phrase"
                            placeholder="{{ Translator::phrase("phrase") }}"
                            value="{{config("pages.form.data.phrase")}}"
                            {{config("pages.form.validate.rules.phrase") ? "required" : ""}} />

                    </div>
                </div>

                <div class="form-row">
                    @if (config('app.languages'))
                    @foreach (config('app.languages') as $lang)
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="{{$lang["code_name"]}}">
                            {{ Translator:: phrase("translate".".as.".$lang["translate_name"]) }}
                            @if(config("pages.form.validate.rules.".$lang["code_name"]))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>
                        <input type="text" class="form-control" name="{{$lang["code_name"]}}"
                            id="{{$lang["code_name"]}}"
                            placeholder="{{ Translator::phrase("translate".".as.".$lang["translate_name"]) }}"
                            value="{{config("pages.form.data.".$lang["code_name"])}}"
                            {{config("pages.form.validate.rules.".$lang["code_name"]) ? "required" : ""}} />
                    </div>
                    @endforeach
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
