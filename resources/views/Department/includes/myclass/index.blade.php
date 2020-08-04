<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        @if ($response["success"])
        @foreach ($response["data"] as $row)

        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <a href="#" class="avatar rounded-circle">
                            <img data-src="{{$row['class']["image"]}}">
                        </a>
                    </div>
                    <div class="col ml--2">
                        <h4 class="mb-0">
                            <a href="#">{{$row['class']["name"]}}</a>
                        </h4>

                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('Teacher.includes.myclass.includes.subject',['subjects'=> $row["subjects"]])
            </div>
        </div>

        @endforeach
        @endif

    </div>
</div>
