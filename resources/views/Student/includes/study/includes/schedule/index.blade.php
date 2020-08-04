<div class="row">
    <div class="col">
        @if ($response["success"])
            @foreach ($response["data"] as $schedule)
            <div class="card">
                @include(config("pages.parent").".includes.study.includes.schedule.includes.header")
                @include(config("pages.parent").".includes.study.includes.schedule.includes.body")
                @include(config("pages.parent").".includes.study.includes.schedule.includes.footer")
            </div>
            @endforeach
        @endif
    </div>
</div>
