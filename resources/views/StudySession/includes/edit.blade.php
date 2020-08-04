<div class="row">
    <div class="col-8 offset-2">
        <div class="card-wrapper">
            <form role="{{config("pages.form.role") }}" class="needs-validation" novalidate="" method="POST"
                action="{{config("pages.form.action.detect")}}" id="form-{{config("pages.form.name")}}"
                enctype="multipart/form-data" data-validate="{{json_encode(config('pages.form.validate'))}}">
                <div class="card">
                    <div class="card-header">
                        <h5 class="h3 mb-0">
                            {{ Translator:: phrase("edit.".str_replace("-","_",config("pages.form.name"))) }}</h5>
                    </div>
                    <div class="card-body">
                        @include(config("pages.parent").".includes.form.index")
                    </div>

                    <div class="card-footer">
                        <div class="{{count($listData) > 1 ? "col-md-8":"col-md-12"}}">
                            @if (!request()->ajax())
                            <a href="{{url(config("pages.host").config("pages.path").config("pages.pathview")."list")}}"
                                class="btn btn-default" type="button">{{ Translator:: phrase("back") }}</a>
                            @endif
                            <a href="" name="scrollTo"></a>
                            <button class="btn btn-primary ml-auto pull-right" data-for="update" id="btn-update"
                                name="btn-update" type="submit">{{ Translator:: phrase("update") }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
