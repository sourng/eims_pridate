
<div class="row">
    <div class="col-xl-6 offset-xl-2 col-xs-12 p-0">
        @if ($response['success'])
            @foreach ($response['data'] as $feed)
            <div class="card mb-2 card-posts"  data-feed-id="{{$feed["id"]}}">
                @include("ActivityFeed.includes.feed.includes.header")
                @include("ActivityFeed.includes.feed.includes.body")
                @include("ActivityFeed.includes.feed.includes.footer")
            </div>
            @endforeach
        @endif
    </div>
</div>
