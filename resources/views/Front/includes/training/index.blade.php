<div class="col-12">
    <div class="container">
        <h1 class="my-2 h2">{{Translator::phrase("training")}}</h1>
        <hr class="my-2">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="list-group">
                    @foreach ($study_program["data"] as $key => $program)
                    <a class="list-group-item list-group-item-action rounded-0 {{request("programId") ==  $program["id"] ? "active" : ""}}"
                        data-toggle="tab-content"
                        data-target="#course"
                        href="{{url("training?programId=".$program["id"])}}" role="tab"
                        aria-controls="p-{{$program["id"]}}" aria-selected="true">
                        <div class="title">
                            {{$program["name"]}}
                        </div>

                    </a>
                    @endforeach
                </div>
            </div>

            <div class="col-md-8">
                <div class="tab-content">
                    <div id="course" class="tab-pane fade show active" role="tabpanel" aria-labelledby="course-tab">
                        @include('Front.includes.training.includes.a')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
