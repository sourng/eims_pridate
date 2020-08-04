<link rel="stylesheet" href="{{ asset("/assets/css/paper.css") }}" />
<div class="paper A4 landscape">
    <header class="sticky d-print-none">
        <div>
            <div class="col">
                <button data-target=".sheet.card" onclick="print();" class="btn btn-primary d-print-none">
                    <i class="fas fa-print"></i>
                    {{Translator::phrase("print")}} | (A4) {{Translator::phrase("landscape")}}
                </button>
            </div>
        </div>
    </header>

    @if ($response["success"])
        @foreach ($response["data"] as $row)
        <section class="sheet padding-5mm card h-100">
            @include(config("pages.parent").".includes.print.includes.body",$row)
        </section>
        @endforeach
    @endif


</div>
<footer>
    <div class="copyright d-print-none">
        &copy; 2019 <a href="{{config("app.website")}}" class="font-weight-bold ml-1"
            target="_blank">{{config('app.name')}}</a>
    </div>
</footer>
