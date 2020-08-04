@if($users["success"])
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col">
                <h5 class="h3 mb-0">{{Translator::phrase("user")}}</h5>
            </div>
            <div class="col m-auto float-right text-right">
                <a class=" btn btn-sm btn-link bg-secondary" href="{{url(Auth::user()->role()."/user/list")}}">
                    <i class="fas fa-arrow-square-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-flush list my--3">
            @foreach ($users['data'] as $key => $user)
            @include(Auth::user()->role('view_path').".includes.dashboard.includes.user.includes.a")
            @endforeach
        </ul>
    </div>
</div>
@endif
