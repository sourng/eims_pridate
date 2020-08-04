
<div class="row">
    <div class="col">
        <div class="card">
            @include(config("pages.parent").".includes.study.includes.course.list.includes.header")
            @include(config("pages.parent").".includes.study.includes.course.list.includes.body")
            @include(config("pages.parent").".includes.study.includes.course.list.includes.footer")
        </div>
    </div>
</div>

@include(config("pages.parent").".includes.study.includes.requesting.list.index")
