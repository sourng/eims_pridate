<link rel="stylesheet" href="{{ asset("/assets/css/paper.css") }}" />
<style>
    .table {
        table-layout: fixed;
    }

    header {
        padding: 10px;
        color: white;
        background: var(--app-color);
    }

    .print-option {
        display: none;
    }

    table:hover .print-option {
        display: inherit;
    }
</style>
<div class="paper A4 landscape">
    <header class="sticky">
        <h1 class="d-print-none">
            @if ($response["success"])
            {{$response["data"][0]["quiz"]["institute"]["name"]}}
            @endif
        </h1>
        <div class="">
            <div class="col">
                <button data-toggle="table-to-excel" data-table-id="t1,t2,t3" data-name=""
                    class="btn btn-primary d-print-none {{$response["success"] == false ? "d-none":""}}">
                    <i class="fas fa-file-excel"></i>
                    {{Translator::phrase("Excel")}}
                </button>
                <button data-toggle="table-to-print" data-target=".sheet.card"
                    class="btn btn-primary d-print-none {{$response["success"] == false ? "d-none":""}}">
                    <i class="fas fa-print"></i>
                    {{Translator::phrase("print")}} | (A4) {{Translator::phrase("landscape")}}
                </button>
                <button href="#filter" data-toggle="collapse" class="btn btn-primary" role="button"
                    aria-expanded="false">
                    <i class="fa fa-filter m-0"></i>
                    <span class="d-none d-sm-inline">
                        {{Translator::phrase("filter")}}
                    </span>
                </button>
            </div>

            <div class="col {{$response["success"] == false ? "d-none":""}}">
                <div class="custom-control custom-checkbox mt-2">
                    <input class="custom-control-input" id="table-toggle-color" data-toggle="table-toggle-color"
                        data-table-id="t1,t2,t3" type="checkbox">
                    <label class="custom-control-label" for="table-toggle-color">
                        <span class="ml-4"></span>
                        <span class="fas fa-palette"></span>
                        {{Translator::phrase("color.black. & .white")}}
                    </label>
                </div>
            </div>
        </div>
        <div class="container border-0 p-2">
            <form role="filter" class="needs-validation" method="GET" action="{{request()->url()}}" id="form-filter"
                enctype="multipart/form-data">
                <div class="row flex-lg-row flex-md-row flex-sm-row-reverse flex-xs-row-reverse">
                    <div class="col-12 collapse mb-3" id="filter">
                        <div class="form-row">
                            <div class="col-md-8">
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
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary float-right"><i
                                        class="fa fa-filter-search"></i>
                                    {{ Translator::phrase("search_filter") }}</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>

    </header>



    @if ($response["success"] == false)
    <section class="sheet nodata">
        <div class="nodata-text">{{$response["message"]}}</div>
    </section>
    @else
    <section class="sheet padding-5mm card {{count($response["data"]) > 20 ? "h-100" : "" }}">
        @include(config("pages.parent").".includes.report.includes.body")
    </section>
    @endif
</div>
<footer>
    <div class="copyright d-print-none">
        &copy; 2019 <a href="{{config("app.website")}}" class="font-weight-bold ml-1"
            target="_blank">{{config('app.name')}}</a>
    </div>
</footer>
