@auth
<form role="{{config("pages.form.role")}}" class="needs-validation" novalidate="" method="POST"
    action="{{config("pages.form.action.detect")}}" id="form-{{config("pages.form.name")}}"
    enctype="multipart/form-data" data-toggle="feed-post">
    <div class="create-post-overlay"></div>
    @csrf
    <div class="card mb-2 create-post">
    <div class="card-header p-2 text-sm font-weight-600 bg-secondary m-0" data-update-text="{{Translator::phrase("edit_post")}}">{{Translator::phrase("create_post")}}</div>
        @include("ActivityFeed.includes.form.post.includes.body")
        @include("ActivityFeed.includes.form.post.includes.footer")
    </div>
</form>
@endauth
