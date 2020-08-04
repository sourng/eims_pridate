<div class="card-body p-2 mb-0">
    <div class="media">
        <img alt="" class="avatar rounded-circle mr-2" src="{{Auth::user()->profile()}}">
        <div class="media-body">
            <textarea data-mention-url="{{str_replace("post","user",config("pages.form.action.detect"))}}" class="form-control post-message" placeholder="{{Translator::phrase("what_on_your_mind")}}" name="post_message"
                data-toggle="limit-word" data-limit="200" data-target="#limit-words-count"></textarea>
        </div>
    </div>
    @include("ActivityFeed.includes.form.post.includes.subbody.text")
    @include("ActivityFeed.includes.form.post.includes.subbody.media")
    @include("ActivityFeed.includes.form.post.includes.subbody.link")
</div>
