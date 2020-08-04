<div class="col-xl-12 col-md-12">
    <div class="card card-stats {{count($student) == ($key + 1) ? "m-0" : ""}}">
        <!-- Card body -->
        <div class=" card-body">
        <div class="row">
            <div class="col-12">
                <h5 class="card-title text-muted mb-0 py-2 text-truncate ">{{$item["title"]}}</h5>
            </div>
            <div class="h2 font-weight-bold mt-4 col">
                @isset($item["text"])
                <span>{{$item["text"]}}</span>
                @endisset
                {{$item["gender"]["total"]["text"]}}
            </div>
            <div class="col-auto">
                <div class="icon icon-xl icon-shape bg-gradient-{{$item["color"]}} text-white rounded-circle shadow">
                    @if ($item["icon"])
                    <i class="{{$item["icon"]}}"></i>
                    @if($item["image"])
                    <img src="{{$item["image"]}}" class="w-100">
                    @endif
                    @elseif($item["image"])
                    <img src="{{$item["image"]}}" class="w-100">
                    @endif
                </div>
            </div>
        </div>

        <div class="row mt-3 mb-0 text-sm">
            <div class="col">
                @foreach ($item["gender"] as $key => $gender)
                @if($key != "total")
                <span class="text-blue mr-2">
                    {{$gender["title"]}}
                    {{$gender["text"]}}
                </span>
                @endif
                @endforeach
                @if (app()->getLocale() == "km")
                @foreach ($item["status"] as $key => $status)
                @if($key == 1)
                <a class="mr-2 {{$status["color"]}} p-1 rounded" href="{{$status["link"]}}">
                    {{$status["title"]}}
                    {{$status["text"]}}
                </a>
                @endif
                @endforeach
                @endif
                <div class=" float-right text-right">
                    <a class=" btn btn-sm btn-link bg-secondary" href="{{$item["link"]}}"><i
                            class="fas fa-arrow-square-right"></i></a>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
