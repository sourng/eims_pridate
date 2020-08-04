
<div class="row">
    <div class="col">
        <div class="card">
            @include(config("pages.parent").".includes.study.includes.short_course.list.includes.header")
            @include(config("pages.parent").".includes.study.includes.short_course.list.includes.body")
            @include(config("pages.parent").".includes.study.includes.short_course.list.includes.footer")
        </div>
    </div>
</div>

@include(config("pages.parent").".includes.study.includes.short_course_requesting.list.index")
