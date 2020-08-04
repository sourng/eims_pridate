<div class="card">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            B
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label class="form-control-label" for="full_mark_theory">
                    {{ Translator:: phrase("full_mark_theory") }}

                    @if(config("pages.form.validate.rules.full_mark_theory"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="full_mark_theory" title="Simple select"
                    data-minimum-results-for-search="Infinity"
                    data-placeholder="{{ Translator::phrase("choose.full_mark_theory") }}" name="full_mark_theory"
                    data-select-value="{{config("pages.form.data.full_mark_theory")}}"
                    {{config("pages.form.validate.rules.full_mark_theory") ? "required" : ""}}>
                    @for($i = 10; $i<= 100 ; $i ++) @if (($i % 10)==0 ) <option value="{{$i}}.00">
                        {{$i.".00 ". Translator::phrase("<s>.points") }}</option>
                        @endif

                        @endfor
                </select>


            </div>

            <div class="col-md-6 mb-3">
                <label class="form-control-label" for="pass_mark_theory">
                    {{ Translator:: phrase("pass_mark_theory") }}

                    @if(config("pages.form.validate.rules.pass_mark_theory"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="pass_mark_theory" title="Simple select"
                    data-minimum-results-for-search="Infinity"
                    data-placeholder="{{ Translator::phrase("choose.pass_mark_theory") }}" name="pass_mark_theory"
                    data-select-value="{{config("pages.form.data.pass_mark_theory")}}"
                    {{config("pages.form.validate.rules.pass_mark_theory") ? "required" : ""}}>
                    @for($i = 10; $i<= 100 ; $i ++) @if (($i % 10)==0 ) <option value="{{$i}}.00">
                        {{$i.".00 ". Translator::phrase("<s>.points") }}</option>
                        @endif

                        @endfor
                </select>

            </div>

            <div class="col-md-6 mb-3">
                <label class="form-control-label" for="full_mark_practical">
                    {{ Translator:: phrase("full_mark_practical") }}

                    @if(config("pages.form.validate.rules.full_mark_practical"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="full_mark_practical" title="Simple select"
                    data-minimum-results-for-search="Infinity"
                    data-placeholder="{{ Translator::phrase("choose.full_mark_practical") }}" name="full_mark_practical"
                    data-select-value="{{config("pages.form.data.full_mark_practical")}}"
                    {{config("pages.form.validate.rules.full_mark_practical") ? "required" : ""}}>
                    @for($i = 10; $i<= 100 ; $i ++) @if (($i % 10)==0 ) <option value="{{$i}}.00">
                        {{$i.".00 ". Translator::phrase("<s>.points") }}</option>
                        @endif

                        @endfor
                </select>


            </div>

            <div class="col-md-6 mb-3">
                <label class="form-control-label" for="pass_mark_practical">
                    {{ Translator:: phrase("pass_mark_practical") }}

                    @if(config("pages.form.validate.rules.pass_mark_practical"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="pass_mark_practical" title="Simple select"
                    data-minimum-results-for-search="Infinity"
                    data-placeholder="{{ Translator::phrase("choose.pass_mark_practical") }}" name="pass_mark_practical"
                    data-select-value="{{config("pages.form.data.pass_mark_practical")}}"
                    {{config("pages.form.validate.rules.pass_mark_practical") ? "required" : ""}}>

                    @for($i = 10; $i<= 100 ; $i ++) @if (($i % 10)==0 ) <option value="{{$i}}.00">
                        {{$i.".00 ". Translator::phrase("<s>.points") }}</option>
                        @endif

                        @endfor
                </select>


            </div>
            <div class="col-md-6 mb-3">
                <label class="form-control-label" for="credit_hour">
                    {{ Translator:: phrase("credit_hour") }}

                    @if(config("pages.form.validate.rules.credit_hour"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="credit_hour" title="Simple select"
                    data-minimum-results-for-search="Infinity"
                    data-placeholder="{{ Translator::phrase("choose.credit_hour") }}" name="credit_hour"
                    data-select-value="{{config("pages.form.data.credit_hour")}}"
                    {{config("pages.form.validate.rules.credit_hour") ? "required" : ""}}>

                    @for($i = 10; $i<= 100 ; $i ++) @if (($i % 10)==0 ) <option value="{{$i}}">
                        {{ Translator::phrase($i."<s>.hour") }}</option>
                        @endif

                        @endfor
                </select>

            </div>
        </div>
    </div>
</div>
