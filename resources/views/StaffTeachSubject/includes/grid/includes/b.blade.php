<div class="card-body p-0">
    <div class="row">
        <div class="col">
            @if ($response["success"])
            @foreach ($response["data"] as $year => $subjects)

            <div class="card">
                <div class="card-header">
                    <h2 class="h2 font-weight-bold mb-0">
                        {{$year}}
                    </h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($subjects as $row)
                        <div class="col-xl-3 col-md-6">
                            <a href="{{ $row["action"]["link"]}}">
                                <div class="card card-stats">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0">
                                                    {{$row["study_subject"]["name"]}}</h5>
                                                <span class="font-weight-bold mb-0 text-muted">
                                                    {{$row["lesson_count"]}}
                                                    {{Translator::phrase("lesson")}}
                                                </span>
                                            </div>
                                            <div class="col-4">
                                                <img src="{{$row["study_subject"]["image"]}}" alt="" class="w-100">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <a href="{{$row["staff"]["action"]["view"]}}" class="list-group-item list-group-item-action">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <img alt="Image placeholder" src="{{$row["staff"]["photo"]}}"
                                                        class="avatar rounded-circle">
                                                </div>
                                                <div class="col ml--2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h4 class="mb-0 text-sm">
                                                                {{$row["staff"]["first_name"]}} {{$row["staff"]["last_name"]}}
                                                            </h4>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>


                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>

                        @endforeach
                    </div>
                </div>
                {{-- @include(config("pages.parent").".includes.teaching.includes.schedule.includes.body") --}}

            </div>
            @endforeach
            @endif
        </div>
    </div>

</div>
