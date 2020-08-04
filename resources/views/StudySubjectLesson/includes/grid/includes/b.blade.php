<div class="card-body">
    <div class="row">
        @if ($response["success"])
        @foreach ($response["data"] as $row)
        <div class="col-lg-2 col-sm-3">
            <a data-href="{{$row["action"]["view"]}}" data-checked-show="view" data-target="#modal"
                data-backdrop="static" data-keyboard="false">
                <div class="card">
                    <div class="card-body p-2">
                        <img data-src="{{$row["image"]}}" class="img-center img-fluid" style="width: 140px;">
                        <div class="pt-2 text-center">
                            <h5 class="h3 title">
                                <span class="d-block text-truncate">{{$row["title"]}}</span>
                            </h5>
                        </div>
                        <div class="avatar avatar-sm rounded-circle float-right">
                            <img data-src="{{$row["staff_teach_subject"]["staff"]["photo"]}}">
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        @endif
    </div>
</div>
