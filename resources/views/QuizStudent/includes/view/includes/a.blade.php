<div class="card-header">
    @if ($quiz["success"])
        <h3>{{$quiz["data"][0]["name"]}} | {{$quiz["data"][0]["institute"]["name"]}}</h3>
    @endif
</div>
<div class="card-header">
    <div class="list-group list-group-flush">
        <div href="#" class="list-group-item">
            <div class="row">
                <div class="avatar avatar-xl rounded">
                    <img data-src="{{config("pages.form.data.student.photo")}}" alt=""
                        id="crop-image">
                </div>
                <div class="col ml--2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 text-sm">
                                {{config("pages.form.data.student.name")}}
                            </h4>
                        </div>
                    </div>
                    <p class="text-sm mb-0">
                        {{config("pages.form.data.student.node.gender.name")}}
                    </p>
                    <p class="text-sm mb-0">
                        {{config("pages.form.data.student.node.email")}}
                    </p>
                    <p class="text-sm mb-0">
                        {{config("pages.form.data.student.node.phone")}}
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
