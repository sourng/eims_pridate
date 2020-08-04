<div class="row mb-4">
    @foreach ($subjects as $subject)
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <a href="#" class="avatar rounded-circle">
                            <img data-src="{{$subject["image"]}}">
                        </a>
                    </div>
                    <div class="col ml--2">
                        <h4 class="mb-0">
                            <a href="#">{{$subject["name"]}}</a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
