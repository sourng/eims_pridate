
@if ($share)
    <div class="card-shared border m-3">
        <div class="card-header d-flex align-items-center p-2 m-0">
            <div class="d-flex align-items-center card-author-avatar">
                <a href="#">
                    <img data-src="{{$share["user"]["profile"]}}" class="avatar rounded-circle">
                </a>
                <div class="mx-3">
                    <div class="card-author">
                        <a data-toggle="card-author" data-user='{{json_encode($share["user"])}}' href="#" class="text-dark font-weight-600 text-sm">
                            {{$share["user"]["name"]}}
                        </a>
                    </div>
                    <div class="d-flex">
                        <small class="text-muted mr-2 card-who-see" data-toggle="who-see" data-a="{{$share["who_see"]}}"><i
                                class="fas fa-{{$share["who_see"] == "public" ? "globe-asia" : "lock"}}"></i> </small>
                        <small class="text-muted card-time text-xs" datetime="{{$share["created_at"]}}">
                            <span class="preload d-block" style="width: 100px;margin-top: 3px;"><span class="preload-bg"
                                    style=""></span></span>
                        </small>
                    </div>

                </div>
            </div>
        </div>
        @include("ActivityFeed.includes.share.includes.body")

    </div>
@endif
