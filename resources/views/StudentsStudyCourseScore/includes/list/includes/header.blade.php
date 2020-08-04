<div class="card-header">
    <div class="col-lg-12 p-0">
        <a href="{{config("pages.form.action.detect")}}" class="btn btn-primary mb-3" data-toggle="modal-ajax"
            data-target="#modal" data-backdrop="static" data-keyboard="false">
            <i class="fa fa-plus m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("add")}}
            </span>
        </a>
        <a href="#" data-href="{{config("pages.form.action.view")}}" class="btn btn-primary mb-3 disabled"
            data-checked-show="view" data-target="#modal" data-backdrop="static" data-keyboard="false">
            <i class="fa fa-eye m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("view")}}
            </span>
        </a>
        <a href="#" data-href="{{config("pages.form.action.edit")}}" class="btn btn-primary mb-3 disabled"
            data-checked-show="edit" data-target="#modal" data-backdrop="static" data-keyboard="false">
            <i class="fa fa-edit m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("edit")}}
            </span>
        </a>
        <a href="#" data-href="{{config("pages.form.action.delete")}}" class="btn btn-danger mb-3 disabled"
            data-toggle="sweet-alert" data-sweet-alert="confirm" sweet-alert-controls-id="" data-checked-show="delete">
            <i class="fa fa-trash m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("delete")}}
            </span>


        </a>

        <a href="#filter" data-toggle="collapse" class="btn btn-primary mb-3" role="button" aria-expanded="false">
            <i class="fa fa-filter m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("filter")}}
            </span>
        </a>

        <a href="#" data-toggle="report" class="float-right btn btn-success mb-3" role="button" aria-expanded="false">
            <i class="fas fa-file-export m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("report")}}
            </span>
        </a>
    </div>


</div>
<div class="card-header border-0 pb-0 collapse"   id="filter">
    <form role="search" class="needs-validation" method="GET" action="{{request()->url()}}" id="form-datatable-filter"
        enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-8 mb-3">
                <select class="form-control" data-toggle="select" id="study_course_session"
                    title="Simple select"
                   
                    data-allow-clear="true"

                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.study_course_session") }}"
                    name="course-sessionId" data-select-value="{{request('course-sessionId')}}">
                    @foreach($study_course_session["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-4">
                <button type="submit" class="btn btn-primary float-right"><i
                        class="fa fa-filter-search"></i> {{Translator::phrase("search_filter")}}</button>
            </div>

        </div>
    </form>
</div>
