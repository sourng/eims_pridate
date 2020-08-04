<div class="col-12 p-0">
    <div class="container p-0">
        @include("ActivityFeed.includes.model.index")
        <h1 class="my-2 h2 px-3">{{Translator::phrase("news. & .even")}}</h1>
        <hr class="my-2">
        <div class="row">
            <div class="col-xl-2 col-xs-12 mb-3">
            </div>
            <div class="col-xl-6 col-xs-12">
                @auth
                    @if (in_array(Auth::user()->role_id ,explode(",",env("FEED_POST_ROLE","1,2,8"))))
                        @include("ActivityFeed.includes.form.post.index")
                    @endif
                @endauth



                @if ($response['success'])
                <div class="card-posts-wrapper">
                    @foreach ($response['data'] as $feed)
                    <div class="card mb-2 card-posts" data-page="{{$response["pages"]["current_page"]}}"
                        data-feed-id="{{$feed["id"]}}">
                        @include("ActivityFeed.includes.feed.includes.header")
                        @include("ActivityFeed.includes.feed.includes.body")
                        @include("ActivityFeed.includes.feed.includes.footer")
                    </div>
                    @endforeach
                </div>
                @else
                <div class="card-posts-wrapper"></div>
                @endif
            </div>
        </div>
    </div>
</div>
