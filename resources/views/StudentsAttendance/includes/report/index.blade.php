<link rel="stylesheet" href="{{ asset("/assets/css/paper.css") }}" />
<style>
    .table {
        table-layout: fixed;
    }

    header {
        padding: 10px;
        color: white;
        background: var(--app-color, blueviolet);
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
        @php
        $name = Translator::day(DateHelper::dayOfWeek(request("year")."-".request("month")."-".$i)["day"],null,"short");
        @endphp
        @if($study_course_session["success"])
        @php
        $name = $study_course_session["data"][0]["name"];
        @endphp
        <h1 class="d-print-none">
            {{$study_course_session["data"][0]["study_course_schedule"]["institute"]["name"]}}
        </h1>

        @endif

        <div class="{{$response["success"] == false ? "d-none":""}}">
            <div class="col">
                <button data-toggle="table-to-excel" data-table-id="t1,t2,t3" data-name="{{$name}}"
                    class="btn btn-primary d-print-none">
                    <i class="fas fa-file-excel"></i>
                    {{Translator::phrase("Excel")}}
                </button>
                <button data-toggle="table-to-print" data-target=".sheet.card" class="btn btn-primary d-print-none">
                    <i class="fas fa-print"></i>
                    {{Translator::phrase("print")}} | (A4) {{Translator::phrase("landscape")}}
                </button>
            </div>

            <div class="col">
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
    </header>

    @if ($response["success"] == false)
    <section class="sheet nodata">
        <div class="nodata-text">{{Translator::phrase("no_data")}}</div>
    </section>
    @else
    <section class="sheet padding-5mm card {{count($response["data"]) > 20 ? "h-100" : "" }}">
        @include(config("pages.parent").".includes.list.includes.body")
    </section>
    @endif
</div>
<footer>
    <div class="copyright d-print-none">
        &copy; 2019 <a href="{{config("app.website")}}" class="font-weight-bold ml-1"
            target="_blank">{{config('app.name')}}</a>
    </div>
</footer>
