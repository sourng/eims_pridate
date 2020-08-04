<li class="list-group-item px-0">
    <div class="row align-items-center">
        <div class="col-auto">
            <a href="#" class="avatar rounded-circle">
                <img src="{{$user["profile"]}}">
            </a>
        </div>
        <div class="col ml--2">
            <h4 class="mb-0">
                <a href="#!">{{$user["name"]}}</a>
            </h4>
            <small class="p-1 rounded {{$user["account_status"]["color"]}}">{{$user["account_status"]["name"]}}</small>
        </div>
        <div class="col-auto">
            <span class="text-{{$user["status"]? "success" : ""}}">●</span>
            <small>{{$user["status"]? Translator::phrase("online") :Translator::phrase("offline")}}</small>
        </div>
    </div>
</li>
