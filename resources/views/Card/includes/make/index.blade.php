<form role="{{config("pages.form.role")}}" class="needs-validation" method="POST"
    action="{{config("pages.form.action.detect")}}" id="form-card-make"
    enctype="multipart/form-data" data-validate="{{json_encode(config('pages.form.validate'))}}">
    <div class="row">
        <div class="col-md-12">
            <div class="sticky-top" data-spy="affix" data-offset-top="100">
                @include("Card.includes.make.includes.a")
            </div>
        </div>
    </div>
</form>
