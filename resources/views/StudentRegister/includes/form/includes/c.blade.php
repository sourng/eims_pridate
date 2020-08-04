<div class="card">
    <div class="card-header p-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            (C) {{ Translator:: phrase("address") }}
        </label>
    </div>
    <div class="card-body">
        <div class="collapse show" id="other_pob" data-control-value-id="other_pob"
            data-toggle-collapse="{{request()->segment(3) == "view" ? "show" : "pob"}}">
            <div class="form-row">
                <div class="col-md-12">
                    <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123"
                        class="form-control-label" for="permanent_address">

                        {{ Translator:: phrase("permanent_address") }}
                        @if (config("pages.form.validate.rules.permanent_address"))
                        <span class="badge badge-md badge-circle badge-floating badge-danger"
                            style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span> @endif
                    </label>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                            </div>
                            <textarea type="text" class="form-control" id="permanent_address"
                                placeholder="{{ Translator::phrase("permanent_address") }}" value=""
                                {{config("pages.form.validate.rules.permanent_address") ? "required" : ""}}
                                name="permanent_address">{{config("pages.form.data.permanent_address")}}</textarea>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card mb-0">
    <div class="card-body">
        <div class="collapse show" id="other_current" data-control-value-id="other_current"
            data-toggle-collapse="{{request()->segment(3) == "view" ? "show" : "current"}}">
            <div class="form-row">
                <div class="col-md-12">
                    <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123"
                        class="form-control-label" for="temporaray_address">

                        {{ Translator:: phrase("temporaray_address") }}
                        @if(config("pages.form.validate.rules.temporaray_address"))
                        <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                            <i class="fas fa-asterisk fa-xs"></i>
                        </span>
                        @endif
                        @if (request()->segment(3) != "view")
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="same-values"
                            data-same-value="other_pob"
                            data-append-value="other_current">{{ Translator:: phrase("same.permanent_address") }}</button>
                        @endif
                    </label>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <textarea type="text" class="form-control" id="temporaray_address"
                                placeholder="{{ Translator::phrase("temporaray_address") }}" value=""
                                {{config("pages.form.validate.rules.temporaray_address") ? "required" : ""}}
                                name="temporaray_address">{{config("pages.form.data.temporaray_address")}}</textarea>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
