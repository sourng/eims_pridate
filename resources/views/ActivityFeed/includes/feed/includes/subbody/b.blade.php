<div class="row card-footer align-items-center m-0 py-2 {{count($feed['comment']) ? "border-bottom" : ""}}">
    <div class="col-xl-12">
        <div class="d-flex text-nowrap card-reaction-wrapper">

            @if ($feed["reaction"])
                <div class="col reaction-stat">
                    @php
                        $you_react  = $feed["reaction"][0]['you_react'];
                        $other_react_name = $feed["reaction"][0]['other_react_name'];
                    @endphp
                    <span class="reaction-emo">
                        @foreach ($feed["reaction"][0]["reaction"] as $reaction)
                            @if ($reaction)
                                <span class="reaction-btn-{{$reaction}}"></span>
                            @endif
                        @endforeach
                    </span>
                    <span class="reaction-details" data-you-react="{{$you_react}}" data-lable-you="{{Translator::phrase("you")}}" data-lable-other="{{$other_react_name}}">
                        @if ($you_react)
                             @if ($other_react_name)
                                {{Translator::phrase("you") .", ".$other_react_name}}
                            @else
                                {{Translator::phrase("you")}}
                            @endif
                        @else
                            {{$other_react_name}}
                        @endif
                    </span>
                </div>
            @else
            <div class="col reaction-stat-clone">
                <span class="reaction-emo"></span>
                <span class="reaction-details" data-you-react="" data-lable-you="{{Translator::phrase("you")}}" data-lable-other=""></span>
            </div>
            @endif
            <div class="card-events">
                @if($feed["reaction"])
                    <a data-count="{{$feed["reaction"][0]["like"]}}" data-toggle="view-reaction" data-feed-id="{{$feed["id"]}}">
                        {{Translator::phrase("like")}}
                    </a>
                @else
                    <a data-count="0" data-toggle="view-reaction" data-feed-id="{{$feed["id"]}}">
                        {{Translator::phrase("like")}}
                    </a>
                @endif


                    @php
                        $count_comment = 0;
                    @endphp
                    @foreach ($feed['comment'] as $comment)
                        @php
                             $count_comment += 1;
                             $count_comment += count($comment["replied"]);
                        @endphp
                    @endforeach

                <a data-count="{{$count_comment}}" data-toggle="view-comment" data-feed-id="{{$feed["id"]}}">
                    {{Translator::phrase("comment")}}
                </a>
            </div>
        </div>

    </div>
    @auth
    <div class="col-xl-12  border-top py-2">
        <div class="card-actions">
            <div class="row">
                <div class="col-xl-4 col-sm-4 col-4 text-nowrap">
                    <button class="btn w-100 reaction-btn" data-toggle="reaction" data-feed-id="{{$feed["id"]}}" data-react={{($feed["reaction"] && $feed["reaction"][0]["you_react"]) ? $feed["reaction"][0]["you_react"] : ""}}>
                            @if ($feed["reaction"] && $feed["reaction"][0]["you_react"])
                                <span class="reaction-btn-emo reaction-btn-{{$feed["reaction"][0]["you_react"]}}"></span>
                                <span class="reaction-btn-text reaction-btn-text-{{$feed["reaction"][0]["you_react"]}} active">{{Translator::phrase($feed["reaction"][0]["you_react"])}}</span>
                            @else
                            <i class="reaction-btn-emo fas fa-thumbs-up"></i>
                            <span class="reaction-btn-text">{{Translator::phrase("Like")}}</span>
                            @endif

                    </button>
                </div>
                <div class="col-xl-4 col-sm-4 col-4 text-nowrap">
                    <button class="btn w-100 ">
                        <i class="fa fa-comment" aria-hidden="true"></i>
                        {{Translator::phrase("comment")}}
                    </button>
                </div>
                <div class="col-xl-4 col-sm-4 col-4 text-nowrap">
                <button data-toggle="share" data-feed-id="{{($feed["type"]  == "share" ? $feed["share"]["feed_id"] : $feed["id"] )}}" class="btn w-100">
                        <i class="fa fa-share" aria-hidden="true"></i>
                        {{Translator::phrase("share")}}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endauth


</div>
