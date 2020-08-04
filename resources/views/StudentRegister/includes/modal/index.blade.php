<div class="col">
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="add_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" class="h3 mr-2">
                        {{ Translator:: phrase(config("pages.form.role").'.'.str_replace("-","_",config("pages.form.name"))) }}
                    </h6>

                    <a href="{{config("pages.form.action.detect")}}" target="_blank" class="full-link"><i
                            class="fas fa-external-link"></i> </a>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <form action="{{config("pages.form.action.detect")}}/excel" enctype="multipart/form-data"
                        method="POST">
                        @csrf

                        <div class="">
                            <label class="form-control-label" for="xfile">File Excel</label>
                            <input type="file" class="form-control" id="xfile" name="xfile" accept=".xls,.xlsx">
                        </div>

                        <button class="btn btn-primary float-right mt-3"
                            type="submit">{{Translator::phrase("Run")}}</button>
                    </form> --}}
                </div>

            </div>
        </div>
    </div>
</div>
