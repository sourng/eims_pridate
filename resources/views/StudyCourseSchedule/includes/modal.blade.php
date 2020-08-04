<div class="col">
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="add_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <form role="{{config("pages.form.role")}}" class="needs-validation" method="POST"
                action="{{config("pages.form.action.detect")}}" id="form-{{config("pages.form.name")}}"
                enctype="multipart/form-data" data-validate="{{json_encode(config('pages.form.validate'))}}">
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

                    <div class="modal-body p-0">
                        <div class="card m-0">
                            <div class="card-body">
                                @include(config("pages.parent").".includes.form.index")
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="" name="scrollTo"></a>
                                    <button class="btn btn-primary ml-auto float-right" type="submit">
                                        @if (config("pages.form.role") == "add")
                                        {{ Translator:: phrase("save") }}
                                        @elseif(config("pages.form.role") == "edit")
                                        {{ Translator:: phrase("update") }}
                                        @elseif(config("pages.form.role") == "view")
                                        {{ Translator:: phrase("goto.edit") }}
                                        @endif

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>
