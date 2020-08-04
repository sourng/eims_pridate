<div class="row">
    <div class="col-xl-12">
        <div class="card-wrapper">
            <form role="{{config("pages.form.role")}}" class="needs-validation" novalidate="" method="POST" action="{{config("pages.form.action.detect")}}" id="form-{{config("pages.form.name")}}"
                enctype="multipart/form-data" data-validate="{{json_encode(config('pages.form.validate'))}}">
                <div class="card">
                    <div class="card-header">
                        <h5 class="h3 mb-0">
                            {{ Translator:: phrase(config("pages.form.role").".".str_replace("-","_",config("pages.form.name"))) }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                @csrf
                                @if(config('pages.form.data'))
                                <input type="hidden" name="id" value="{{config('pages.form.data.id')}}">
                                @endif
                                @include(config("pages.parent").".includes.form.includes.a")
                            </div>
                        </div>
                    </div>


                    <div class="card-footer">
                        @if (!request()->ajax())
                        <a href="{{url(config("pages.host").config("pages.path").config("pages.pathview")."list")}}"
                            class="btn btn-default" type="button">{{ Translator:: phrase("back") }}</a>
                        @endif

                        <a href="" name="scrollTo"></a>
                        <button href="{{config("pages.form.action.add")}}" class="btn btn-primary ml-auto pull-right"
                            data-for="save" id="btn-save" name="btn-save"
                            type="submit">{{ Translator:: phrase("save") }}</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
