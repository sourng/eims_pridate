<div class="col">
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="add_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable {{count($listData) > 1 ? "modal-xl" : "modal-lg"}}"
            role="document">
            @if (config("pages.form.role") !== "view")
            <form role="{{config("pages.form.role")}}" class="needs-validation" method="POST"
                action="{{config("pages.form.action.detect")}}" id="form-{{config("pages.form.name")}}"
                enctype="multipart/form-data" data-validate="{{json_encode(config('pages.form.validate'))}}">
                @endif

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
                                @if (request()->ajax())
                                @include(config("pages.parent").".includes.modal.includes.a")
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer {{config("pages.form.role") == "view"? "invisible": ""}}">
                        <div class="col">
                            <div class="row">
                                <div class="{{count($listData) > 1 ? "col-md-8":"col-md-12"}}">
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
                @if (config("pages.form.role") !== "view")
            </form>
            @endif

        </div>
    </div>
    <div class="template-table-quiz-student d-none">
        <div class="table-responsive">
            <table class="table border">
                <thead>
                    <tr>
                        <th width="1">{{Translator::phrase("numbering")}}​</th>
                        <th width="1">{{Translator::phrase("quiz_type")}}​</th>
                        <th>{{Translator::phrase("question. & .answered")}}​</th>
                        <th width="1">{{Translator::phrase("marks")}}​</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
