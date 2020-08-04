
<div class="row">
    <div class="col-xl-6 offset-xl-2 col-xs-12 p-0">
        @include("ActivityFeed.includes.form.post.index")
        @if ($response['success'])
        <div class="card-posts-wrapper">
            @foreach ($response['data'] as $feed)
            <div class="card mb-2 card-posts" data-page="{{$response["pages"]["current_page"]}}" data-feed-id="{{$feed["id"]}}">
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
