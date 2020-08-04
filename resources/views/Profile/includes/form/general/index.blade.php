<div class="row">
    <div class="col-xl-12 col-lg-12  col-md-12 col-sm-12 col-xs-12">
        <div class="card-wrapper">
            <form role="{{config("pages.form.role")}}" class="needs-validation" novalidate="" method="POST"
                action="{{config("pages.form.action.detect")}}" id="form-{{config("pages.form.name")}}"
                enctype="multipart/form-data" data-validate="{{json_encode(config('pages.form.validate'))}}">
                <div class="card p-0">
                    <div class="card-header">
                        <h5 class="h3 mb-0">
                            {{ Translator:: phrase("general") }}
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-md-12">
                                @include(config("pages.parent").".includes.form.general.includes.a")
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="" name="scrollTo"></a>
                        <button
                            class="btn btn-primary ml-auto float-right {{config("pages.form.role") == "view"? "d-none": ""}}"
                            type="submit">
                            {{ Translator:: phrase("update") }}
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
