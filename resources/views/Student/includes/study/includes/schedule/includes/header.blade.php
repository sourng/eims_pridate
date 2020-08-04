<div class="card-header border-0">
    <a href="#filter" data-toggle="collapse" class="btn btn-primary mb-3" role="button" aria-expanded="false">
        <i class="fa fa-filter m-0"></i>
        <span class="d-none d-sm-inline">
            {{Translator::phrase("filter")}}
        </span>
    </a>
</div>
<div class="card-header border-0 pb-0">
    <form role="search" class="needs-validation" method="GET" action="{{request()->url()}}" id="form-search"
        enctype="multipart/form-data">

        <div class="row flex-lg-row flex-md-row flex-sm-row-reverse flex-xs-row-reverse">
            <div class="col-12 collapse mb-3"
                id="filter">
                <div class="form-row">
                    <div class="col-xl-8 mb-3">
                        <select class="form-control" data-toggle="select" id="study_course_session"
                            title="Simple select" data-url="{{$study_course_session["pages"]["form"]["action"]["add"]}}"
                            data-allow-clear="true"
                        
                            data-text="{{ Translator::phrase("add_new_option") }}"
                            data-placeholder="{{ Translator::phrase("choose.study_course_session") }}"
                            name="course-sessionId" data-select-value="{{request('course-sessionId')}}">
                            @foreach($study_course_session["data"] as $o)
                            <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-4 mb-3">
                        <button type="submit" class="btn btn-primary float-right"><i class="fa fa-filter-search"></i>
                            {{ Translator::phrase("search_filter") }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
