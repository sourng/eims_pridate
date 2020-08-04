

@auth
<div id="feed-{{$feed["id"]}}" class="card-footer p-2">
    <div class="media align-items-center">
        <img alt="" class="avatar avatar-sm rounded-circle mr-2" src="{{Auth::user()->profile()}}">
        <div class="media-body">
            <form data-toggle="feed-comment" action="{{str_replace("post","comment",config("pages.form.action.detect"))}}" method="POST">
                @csrf
                <input type="hidden" name="feed_id" value="{{$feed["id"]}}">
                <input data-mention-url="{{str_replace("post","user",config("pages.form.action.detect"))}}" data-toggle="comment" name="comment" class="form-control form-control-sm rounded-pill"
                    placeholder="{{Translator::phrase("write_a_comment")}}" ></textarea>
            </form>
        </div>
    </div>
</div>
@endauth
