<!-- Comments -->
<div class="mb-1 card-comments-wrapper">
    @if ($feed['comment'])
    @foreach ($feed['comment'] as $comment)
    <div class="ct-comment media media-comment py-2" data-comment-id="{{$comment["id"]}}">
        <img alt="" class="avatar avatar-sm media-comment-avatar rounded-circle"
            data-src="{{$comment["user"]["profile"]}}">
        <div class="media-body">
            <div class="media-comment-text">
                <div class="d-flex">
                <div class="{{$comment["type"] == "text" ? "d-flex bg-secondary" : ""}} rounded-lg p-1">
                        <h6 class="h5 text-nowrap mb-0">{{$comment["user"]["name"]}}</h6>

                        @php
                            $m = $comment["comment"];
                        @endphp
                        @if ($comment["mention"])
                                @foreach ($comment["mention"] as $key => $mention)
                                    @php
                                        $template = '<a href="#" data-user=\''.json_encode($mention).'\' class="emojionearea-mention">'.$mention['name'].'</a>';
                                        $m = str_replace('@['.$key.']',$template,$m);
                                    @endphp
                                @endforeach
                        @endif
                        @if ($comment["type"] == "text")
                        <span class="text-sm ml-2" data-emoji-convert="true">{!!$m!!}</span>
                        @else
                        <div class="text-sm ml-2" data-sticker-convert="true" data-name="{!!$m!!}"></div>
                        @endif

                    </div>
                </div>

                <div class="icon-actions d-inline-flex">
                    <small class="text-muted text-xs text-right ml-auto" datetime="{{$comment["created_at"]}}">
                        <span class="preload d-block" style="width: 100px;margin-top: 3px;"><span class="preload-bg"
                                style=""></span></span>
                    </small>
                    @auth
                        @if (Auth::user()->id  !== $comment["user"]["id"])
                        <a href="#"
                            data-user='{!!json_encode(["id" => $comment["user"]["id"],"name" => $comment["user"]["name"]])!!}'
                            data-toggle="scroll-to" data-target="#comment-{{$comment["id"]}}" data-focus="comment"
                            class="text-muted text-xs text-right ml-2">
                            {{Translator::phrase("reply")}}
                        </a>
                        @endif
                    @endauth

                </div>
                <div class="ct-replied card-replieds-wrapper">
                    @if ($comment["replied"])
                    @foreach ($comment["replied"] as $replied)
                    <div class="media media-comment pl-2">
                        <div class="media" data-replied-id="{{$replied["id"]}}">
                            <img alt="" class="avatar avatar-xs rounded-circle mr-2"
                                data-src="{{$replied["user"]["profile"]}}">
                            <div class="media-body">
                                <div class="media-comment-text p-0">
                                    <div class="{{$replied["type"] == "text" ? "d-flex bg-secondary" : ""}} rounded-lg p-1">
                                        <h6 class="h5 text-nowrap mb-0">{{$replied["user"]["name"]}}</h6>
                                        @php
                                            $mr = $replied["comment"];
                                        @endphp
                                        @if ($replied["mention"])
                                                @foreach ($replied["mention"] as $key => $mention)
                                                    @php
                                                        $template = '<a href="#" data-user=\''.json_encode($mention).'\' class="emojionearea-mention">'.$mention['name'].'</a>';
                                                        $mr = str_replace('@['.$key.']',$template,$mr);
                                                    @endphp
                                                @endforeach
                                        @endif
                                        @if ($replied["type"] == "text")
                                        <span class="text-sm ml-2" data-emoji-convert="true">{!!$mr!!}</span>
                                        @else
                                        <div class="text-sm ml-2" data-sticker-convert="true" data-name="{!!$mr!!}"></div>
                                        @endif
                                    </div>
                                    <div class="icon-actions d-inline-flex">
                                        <small class="text-muted text-xs text-right ml-auto"
                                            datetime="{{$replied["created_at"]}}">
                                            <span class="preload d-block" style="width: 100px;margin-top: 3px;"><span
                                                    class="preload-bg" style=""></span></span>
                                        </small>
                                        @auth
                                        @if (Auth::user()->id  !== $replied["user"]["id"])
                                        <a href="#"
                                            data-toggle="scroll-to" data-target="#comment-{{$comment["id"]}}" data-focus="comment"
                                            class="text-muted text-xs text-right ml-2">
                                            {{Translator::phrase("reply")}}
                                        </a>
                                        @else
                                        <a href="#"
                                            data-user='{!!json_encode(["id" => $replied["user"]["id"],"name" => $replied["user"]["name"]])!!}'
                                            data-toggle="scroll-to" data-target="#comment-{{$comment["id"]}}" data-focus="comment"
                                            class="text-muted text-xs text-right ml-2">
                                            {{Translator::phrase("reply")}}
                                        </a>
                                        @endif
                                    @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                @auth
                <div id="comment-{{$comment["id"]}}" class="media align-items-center d-none">
                    <img alt="" class="avatar avatar-xs rounded-circle mr-2" src="{{Auth::user()->profile()}}">
                    <div class="media-body pr-2">
                        <form action="{{str_replace("post","replied",config("pages.form.action.detect"))}}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="comment_id" value="{{$comment["id"]}}">
                            <input data-mention-url="{{str_replace("post","user",config("pages.form.action.detect"))}}"
                                data-toggle="replied-comment" name="comment"
                                class="form-control form-control-sm rounded-pill"
                                placeholder="{{Translator::phrase("write_a_reply")}}" />
                        </form>
                    </div>
                </div>
                @endauth

            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
