<div class="card m-0">
    <div class="card-body">
        <div class="row">
            <div class="col-12 form-row">
                <div class="col-md-12 mb-3">
                    <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="{{config("pages.form.validate.questions.expired")}}"
                        class="form-control-label" for="expired">
                        {{ Translator:: phrase("qrcode.expired") }}
                        @if(config("pages.form.validate.rules.expired"))
                        <span
                            class="badge badge-md badge-circle badge-floating badge-danger"
                            style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span> @endif
                    </label>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-school"></i></span>
                            </div>
                            <select class="form-control" data-toggle="select" id="expired" title="Simple select"
                                data-minimum-results-for-search="Infinity"
                                data-placeholder="{{ Translator::phrase("qrcode.expired") }}" name="expired"
                                data-allow-clear="true"
                                data-select-value="{{config("pages.form.data.expired.id")}}"
                                {{config("pages.form.validate.rules.expired") ? "required" : ""}}>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{$i == 1 ? '+'.$i.' month' : '+'.$i.' months'}}">{{ $i .' '.Translator::phrase("month")}}</option>
                                @endfor
                                @for ($i = 1; $i <= 4; $i++)
                                    <option value="{{$i == 1 ? '+'.$i.' year' : '+'.$i.' years'}}">{{ $i .' '.Translator::phrase("year")}}</option>
                                @endfor

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
