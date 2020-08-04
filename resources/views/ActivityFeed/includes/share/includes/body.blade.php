<div class="card-body p-0 m-0">
    @php
    $caption = $share['post_message'];
    @endphp

    @if ($share['type'] == "text")
        @if ($share['theme_color'])
            <div class="post text-white bg-gradient-{{$share['theme_color']["color_name"]}}">
                <div class="post-body">
                    <span class="mb-1 text-xl text-center text-pre-wrap font-weight-600" data-emoji-convert="true">{!!$caption!!}</span>
                </div>
            </div>
        @else
        <div class="mb-1 p-2 text-sm text-caption font-weight-400 text-pre-wrap" data-emoji-convert="true">{!!$caption!!}</div>
        @endif

    @elseif ($share['type'] == "media")
        @if ($caption)
            <div class="mb-1 p-2 text-sm text-caption font-weight-400 text-pre-wrap" data-emoji-convert="true">{!!$caption!!}</div>
        @endif

        @if ($share['media'])
            <div class="card-gallery" data-toggle="gallery-feed1">
                @foreach ($share['media'] as $media)
                    <embed data-id="{{$media["id"]}}" data-type="{{$media["type"]}}" data-src="{{$media['source'] .(($media["type"] == "image") ? "?type=larg" : "")}}"  data-original="{{$media['source'].(($media["type"] == "image") ? "?type=original" : "")}}" />
                @endforeach
            </div>
        @endif

    @elseif ($share['type'] == "link")
        @if ($caption)
        <div class="mb-1 p-2 text-sm text-caption font-weight-400 text-pre-wrap" data-emoji-convert="true">{!!$caption!!}</div>
        @endif

        @foreach ($share['link'] as $links)
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
    @endif

</div>
