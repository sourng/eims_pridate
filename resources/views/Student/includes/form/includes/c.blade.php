<div class="card">
    <div class="card-header p-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            (C) {{ Translator:: phrase("address") }}
        </label>
    </div>

    <div class="card-header p-2 px-4">
        <label class="form-control-label">
            {{ Translator:: phrase("pob") }}
            @if(config("pages.form.validate.rules.pob"))
            <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                <i class="fas fa-asterisk fa-xs"></i>
            </span>
            @endif
        </label>
    </div>
    <div class="card-body">
        <div class="form-row" data-collapse="pob" data-control-value-id="pob">
            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123" class="form-control-label"
                    for="pob_province_fk">
                    {{ Translator:: phrase("province") }}

                    @if(config("pages.form.validate.rules.pob_province_fk"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>

                <select class="form-control" data-toggle="select" id="pob_province_fk" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-allow-clear="true" data-placeholder="{{ Translator::phrase("choose.province") }}"
                    name="pob_province_fk" data-select-value="{{config("pages.form.data.place_of_birth.province.id")}}"
                    data-append-to="#pob_district_fk"
                    data-append-url="{{str_replace("add","?provinceId=",$districts["pages"]["form"]["action"]["add"])}}"
                    {{config("pages.form.validate.rules.pob_province_fk") ? "required" : ""}}>
                    @foreach($provinces["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                        {{ $o["name"]}}</option>
                    @endforeach
                </select>

            </div>

            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123" class="form-control-label"
                    for="pob_district_fk">
                    {{ Translator:: phrase("district") }}
                    @if(config("pages.form.validate.rules.pob_district_fk"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>


                <select disabled {{config("pages.form.data.place_of_birth.district.id")? "" :"disabled"}} class="form-control"
                    data-toggle="select" id="pob_district_fk" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-allow-clear="true" data-placeholder="{{ Translator::phrase("choose.district") }}"
                    name="pob_district_fk" data-select-value="{{config("pages.form.data.place_of_birth.district.id")}}"
                    data-append-to="#pob_commune_fk"
                    data-append-url="{{str_replace("add","?districtId=",$communes["pages"]["form"]["action"]["add"])}}"
                    {{config("pages.form.validate.rules.pob_district_fk") ? "required" : ""}}>
                    @foreach($districts["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                        {{ $o["name"]}}</option>
                    @endforeach
                </select>

            </div>
            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123" class="form-control-label"
                    for="pob_commune_fk">
                    {{ Translator:: phrase("commune") }}
                    @if(config("pages.form.validate.rules.pob_commune_fk"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif

                </label>


                <select disabled {{config("pages.form.data.place_of_birth.commune.id")? "" :"disabled"}} class="form-control"
                    data-toggle="select" id="pob_commune_fk" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}"

                    data-allow-clear="true" data-placeholder="{{ Translator::phrase("choose.commune") }}"
                    name="pob_commune_fk" data-select-value="{{config("pages.form.data.place_of_birth.commune.id")}}"
                    data-append-to="#pob_village_fk"
                    data-append-url="{{str_replace("add","?communeId=",$villages["pages"]["form"]["action"]["add"])}}"
                    {{config("pages.form.validate.rules.pob_commune_fk") ? "required" : ""}}>
                    @foreach($communes["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                        {{ $o["name"]}}</option>
                    @endforeach
                </select>

            </div>

            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123" class="form-control-label"
                    for="pob_village_fk">
                    {{ Translator:: phrase("village") }}
                    @if(config("pages.form.validate.rules.pob_village_fk"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif

                </label>


                <select disabled {{config("pages.form.data.place_of_birth.village.id")? "" :"disabled"}} class="form-control"
                    data-toggle="select" id="pob_village_fk" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}"

                    data-allow-clear="true" data-placeholder="{{ Translator::phrase("choose.village") }}"
                    name="pob_village_fk" data-select-value="{{config("pages.form.data.place_of_birth.village.id")}}"
                    {{config("pages.form.validate.rules.pob_village_fk") ? "required" : ""}}>
                    @foreach($villages["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                        {{ $o["name"]}}</option>
                    @endforeach
                </select>

            </div>
        </div>
        {{-- <a id="hide-show" class="badge badge-warning mb-3" data-toggle="collapse" href="#other_pob" role="button"
            aria-expanded="false" aria-controls="other_pob">{{ Translator:: phrase("other") }}</a> --}}

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


<div class="card">
    <div class="card-header p-2 px-4">
        <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123" class="form-control-label"
            for="pob_resident">

            {{ Translator:: phrase("current_resident") }}
            @if(config("pages.form.validate.rules.pob_resident"))
            <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                <i class="fas fa-asterisk fa-xs"></i>
            </span>
            @endif

            @if (request()->segment(3) != "view")
            <button type="button" class="btn btn-primary btn-sm" data-collapse="current" data-toggle="same-values"
                data-same-value="pob" data-append-value="current">{{ Translator:: phrase("same.pob") }}</button>
            @endif
        </label>
    </div>
    <div class="card-body">
        <div class="form-row" data-collapse="current" data-control-value-id="current">
            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123" class="form-control-label"
                    for="curr_province_fk">
                    {{ Translator:: phrase("province") }}

                    @if(config("pages.form.validate.rules.curr_province_fk"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif
                </label>

                <select class="form-control" data-toggle="select" id="curr_province_fk" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}"

                    data-allow-clear="true" data-placeholder="{{ Translator::phrase("choose.province") }}"
                    name="curr_province_fk"
                    data-select-value="{{config("pages.form.data.current_resident.province.id")}}"
                    data-append-to="#curr_district_fk"
                    data-append-url="{{str_replace("add","?provinceId=",$districts["pages"]["form"]["action"]["add"])}}"
                    {{config("pages.form.validate.rules.curr_province_fk") ? "required" : ""}}>
                    @foreach($provinces["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                        {{ $o["name"]}}</option>
                    @endforeach
                </select>

            </div>

            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123" class="form-control-label"
                    for="curr_district_fk">
                    {{ Translator:: phrase("district") }}
                    @if(config("pages.form.validate.rules.curr_district_fk"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif

                </label>


                <select disabled {{config("pages.form.data.current_resident.district.id")? "" :"disabled"}} class="form-control"
                    data-toggle="select" id="curr_district_fk" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}"

                    data-allow-clear="true" data-placeholder="{{ Translator::phrase("choose.district") }}"
                    name="curr_district_fk"
                    data-select-value="{{config("pages.form.data.current_resident.district.id")}}"
                    data-append-to="#curr_commune_fk"
                    data-append-url="{{str_replace("add","?districtId=",$communes["pages"]["form"]["action"]["add"])}}"
                    {{config("pages.form.validate.rules.curr_district_fk") ? "required" : ""}}>
                    @foreach($curr_districts["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                        {{ $o["name"]}}</option>
                    @endforeach
                </select>

            </div>
            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123" class="form-control-label"
                    for="curr_commune_fk">
                    {{ Translator:: phrase("commune") }}
                    @if(config("pages.form.validate.rules.curr_commune_fk"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif

                </label>


                <select disabled {{config("pages.form.data.current_resident.commune.id")? "" :"disabled"}} class="form-control"
                    data-toggle="select" id="curr_commune_fk" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}"

                    data-allow-clear="true" data-placeholder="{{ Translator::phrase("choose.commune") }}"
                    name="curr_commune_fk" data-select-value="{{config("pages.form.data.current_resident.commune.id")}}"
                    data-append-to="#curr_village_fk"
                    data-append-url="{{str_replace("add","?communeId=",$villages["pages"]["form"]["action"]["add"])}}"
                    {{config("pages.form.validate.rules.curr_commune_fk") ? "required" : ""}}>
                    @foreach($curr_communes["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                        {{ $o["name"]}}</option>
                    @endforeach
                </select>

            </div>

            <div class="col-md-6 mb-3">
                <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123" class="form-control-label"
                    for="curr_village_fk">
                    {{ Translator:: phrase("village") }}
                    @if(config("pages.form.validate.rules.curr_village_fk"))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                        <i class="fas fa-asterisk fa-xs"></i>
                    </span>
                    @endif

                </label>


                <select disabled {{config("pages.form.data.current_resident.village.id")? "" :"disabled"}} class="form-control"
                    data-toggle="select" id="curr_village_fk" title="Simple select"
                    
                    data-text="{{ Translator::phrase("add_new_option") }}"

                    data-allow-clear="true" data-placeholder="{{ Translator::phrase("choose.village") }}"
                    name="curr_village_fk" data-select-value="{{config("pages.form.data.current_resident.village.id")}}"
                    {{config("pages.form.validate.rules.curr_village_fk") ? "required" : ""}}>
                    @foreach($curr_villages["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                        {{ $o["name"]}}</option>
                    @endforeach
                </select>

            </div>
        </div>
        {{-- <a class="badge badge-warning mb-3" data-toggle="collapse" href="#other_current" role="button"
            aria-expanded="false" aria-controls="other_current">{{ Translator:: phrase("other") }}</a> --}}

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
