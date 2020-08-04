<div class="card-header">
    <div class="col-lg-12 p-0">

        <a href="#filter" data-toggle="collapse" class="btn btn-primary mb-3" role="button" aria-expanded="false">
            <i class="fa fa-filter m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("filter")}}
            </span>
        </a>


    </div>


</div>
<div class="card-header border-0 pb-0">
    <form role="search" class="needs-validation" method="GET" action="{{request()->url()}}" id="form-search"
        enctype="multipart/form-data">
        <div class="row flex-lg-row flex-md-row flex-sm-row-reverse flex-xs-row-reverse">
            <div class="col-12 collapse mb-3 p-0" id="filter">
                <div class="col-xl-8 col-12">

                    <div class="form-row">

                        <div class="col-md-12 mb-3">
                            <select class="form-control" data-toggle="select" id="quiz" title="Simple select"
                                 data-allow-clear="true"

                                data-text="{{ Translator::phrase("add_new_option") }}"
                                data-placeholder="{{ Translator::phrase("choose.quiz") }}" name="quizId"
                                data-select-value="{{request('quizId')}}">
                                @foreach($quiz["data"] as $o)
                                <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-xs-12 offset-md-8">
                            <button type="submit" class="btn btn-primary float-right"><i
                                    class="fa fa-filter-search"></i> {{Translator::phrase("search_filter")}}</button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-12">
                <div class="form-row">
                    @if (request("search"))
                    <div class=" col-lg-8 col-md-12 col-sm-12 col-xs-12 mb-3">
                        <div class="search text-center">
                            <span class="">{{Translator::phrase("search_results")}} :</span>
                            <span
                                class="{{$response["success"] ? "text-green font-weight-600" :"text-red font-weight-600"}}">{{request("search")}}</span>
                        </div>
                    </div>
                    @endif

                    <div
                        class="{{request("search") ? "col-lg-4" : "col-lg-4 offset-lg-8"}} col-md-12 col-sm-12 col-xs-12 mb-3">
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
