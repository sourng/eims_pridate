@php
$caption = $feed['post_message'];
@endphp
@if ($feed["mention"])
    @foreach ($feed["mention"] as $key => $mention)
        @php
            $template = '<a href="#" data-user=\''.json_encode($mention).'\' class="emojionearea-mention '.($feed['theme_color'] ? "text-white" : "").'">'.$mention['name'].'</a>';
            $caption = str_replace('@['.$key.']',$template,$caption);
        @endphp
    @endforeach
@endif


@if ($feed['type'] == "text")
    @if ($feed['theme_color'])
        <div class="post text-white bg-gradient-{{$feed['theme_color']["color_name"]}}">
            <div class="post-body">
                <span class="mb-1 text-xl text-center text-pre-wrap font-weight-600" data-emoji-convert="true">{!!$caption!!}</span>
            </div>
        </div>
    @else
    <div class="mb-1 p-2 text-sm text-caption font-weight-400 text-pre-wrap" data-emoji-convert="true">{!!$caption!!}</div>
    @endif

@elseif ($feed['type'] == "media")
    @if ($caption)
        <div class="mb-1 p-2 text-sm text-caption font-weight-400 text-pre-wrap" data-emoji-convert="true">{!!$caption!!}</div>
    @endif

    @if ($feed['media'])
        <div class="card-gallery" data-toggle="gallery-feed1">
            @foreach ($feed['media'] as $media)
                <embed data-id="{{$media["id"]}}" data-type="{{$media["type"]}}" data-src="{{$media['source'] .(($media["type"] == "image") ? "?type=large" : "")}}"  data-original="{{$media['source'].(($media["type"] == "image") ? "?type=original" : "")}}" />
            @endforeach
        </div>
    @endif

@elseif ($feed['type'] == "link")
    @if ($caption)
    <div class="mb-1 p-2 text-sm text-caption font-weight-400 text-pre-wrap" data-emoji-convert="true">{!!$caption!!}</div>
    @endif

    @foreach ($feed['link'] as $links)
        @if ($links['view'] == 1)

            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{$links["link"]}}" target="_blank">
                        <img data-src="{{$links["image"]}}" alt="" class="image" width="200px" height="200px">
                    </a>
                </div>
                <div class="col ml--2">
                    <h4 class="mb-0">
                        <a href="{{$links["link"]}}" target="_blank" class="title">{{$links["title"]}}</a>
                    </h4>
                    <p class="text-sm text-muted mb-0 description">{{$links["description"]}}</p>
                </div>
            </div>

        @elseif ($links['view'] == 2)
            <a href="{{$links["link"]}}" target="_blank">
                <img data-src="{{$links["image"]}}" alt="" class="image w-100">
            </a>
            <div class="align-items-center">
                <div class="col mt-2">
                    <h4 class="mb-0">
                        <a href="{{$links["link"]}}" target="_blank" class="title">{{$links["title"]}}</a>
                    </h4>
                    <p class="text-sm text-muted mb-0 description">{{$links["description"]}}</p>
                </div>
            </div>

        @elseif ($links['view'] == 3)

            {!!$links["code"]!!}

        @endif

    @endforeach
@elseif ($feed['type'] == "share")
    @php
       $share =  $feed['share']['node'];
    @endphp
    @include("ActivityFeed.includes.share.index")
@endif
