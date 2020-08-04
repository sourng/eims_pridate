<div class="card-header">
    <div class="col-lg-12 p-0">
        <a href="{{config("pages.form.action.detect")}}" data-toggle="modal-qrcode" data-backdrop="static"
            data-keyboard="false" class="btn btn-primary mb-3" data-toggle="modal-qrcode" data-target="#modal-qrcode">
            <i class="fa fa-camera m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("add_absent.(.qrcode.)")}}
            </span>
        </a>
        <a href="#" data-href="{{config("pages.form.action.view")}}" class="btn btn-primary mb-3 disabled"
            data-checked-show="view" data-target="#modal" data-backdrop="static" data-keyboard="false">
            <i class="fa fa-eye m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("view")}}
            </span>
        </a>
        <a href="#" data-href="{{config("pages.form.action.edit")}}" class="btn btn-primary mb-3 disabled"
            data-checked-show="edit" data-target="#modal" data-backdrop="static" data-keyboard="false">
            <i class="fa fa-edit m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("edit")}}
            </span>
        </a>
        <a href="#" data-href="{{config("pages.form.action.delete")}}" class="btn btn-danger mb-3 disabled"
            data-toggle="sweet-alert" data-sweet-alert="confirm" sweet-alert-controls-id="" data-checked-show="delete">
            <i class="fa fa-trash m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("delete")}}
            </span>


        </a>
        <a href="#filter" data-toggle="collapse" class="btn btn-primary mb-3" role="button" aria-expanded="false">
            <i class="fa fa-filter m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("filter")}}
            </span>
        </a>
        <a href="#" data-toggle="report" class="float-right btn btn-success mb-3" role="button" aria-expanded="false">
            <i class="fas fa-file-export m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("report")}}
            </span>
        </a>

    </div>


</div>
<div class="card-header border-0 pb-0 collapse"  id="filter">
    <form role="search" class="needs-validation" method="GET" action="{{request()->url()}}" id="form-search"
        enctype="multipart/form-data">
        <div class="row flex-lg-row flex-md-row flex-sm-row-reverse flex-xs-row-reverse">
            <div class="col-md-6 mb-3">
                <select class="form-control" data-toggle="select" id="study_course_session"
                    title="Simple select"

                    data-allow-clear="true"

                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.study_course_session") }}"
                    name="course-sessionId" data-select-value="{{request('course-sessionId')}}">
                    @foreach($study_course_session["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input type="text" class="form-control datepicker" data-start-date=""
                            data-end-date="+1" placeholder="{{ Translator:: phrase("mm_yyyy") }}"
                            type="text" id="month_year" name="month_year"
                            value="{{request('month').'-'.request('year')}}" data-format="mm-yyyy"
                            data-min-view="true" />
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-xs-12">
                <button type="submit" class="btn btn-primary float-right"><i
                        class="fa fa-filter-search"></i> {{Translator::phrase("search_filter")}}</button>
            </div>
            <div class="col-xl-12">
                <div class="form-row">
                    @if (request("search"))
                    <div class=" col-lg-9 col-md-12 col-sm-12 col-xs-12 mb-3">
                        <div class="search text-center">
                            <span class="">{{Translator::phrase("search_results")}} :</span>
                            <span
                                class="{{$response["success"] ? "text-green font-weight-600" :"text-red font-weight-600"}}">{{request("search")}}</span>
                        </div>
                    </div>
                    @endif

                    <div
                        class="{{request("search") ? "col-lg-3" : "col-lg-3 offset-lg-9"}} col-md-12 col-sm-12 col-xs-12 mb-3">
                        <div class="form-group w-100">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="dropdown" data-close="false">
                                        <span class="input-group-text h-100" data-toggle="dropdown">
                                            <i class="fas fa-filter"></i>
                                        </span>
                                        <div
                                            class="p-2 dropdown-menu dropdown-menu-md  dropdown-menu-right dropdown-menu-arrow">
                                            @foreach (config("pages.form.validate.attributes") as $key => $item)
                                            <div class="custom-control custom-checkbox">
                                                @if ($key !== "image" && $key !== "photo")
                                                <input {{array_key_exists($key,request()->all()) ? "checked" : "" }}
                                                    value="✓"
                                                    {{$response["success"] ? "" : (request("search") ? "" : "disabled=disabled")}}
                                                    type="checkbox" class="custom-control-input"
                                                    id="customCheck-{{$key}}" name="{{$key}}">
                                                <label class="custom-control-label lh-150 d-inline"
                                                    for="customCheck-{{$key}}">{{$item}}</label>
                                                @endif

                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="search" id="search" data-toggle="search"
                                    placeholder="{{ Translator::phrase("search") }}" value="{{request("search")}}"
                                    {{$response["success"] ? "" : (request("search") ? "" : "disabled=disabled")}} />
                                <div class="input-group-append" data-toggle="clear-input">
                                    <span class="input-group-text">
                                        <i class="fas {{request("search") ? "fa-times-circle" : "fa-search"}}"></i>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>
