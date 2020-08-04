<div class="col">
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="add_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <form role="{{config("pages.form.role")}}" class="needs-validation" novalidate="" method="POST"
                action="{{config("pages.form.action.detect")}}" id="form-{{config("pages.form.name")}}"
                enctype="multipart/form-data" data-validate="{{json_encode(config('pages.form.validate'))}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" class="h3 mr-2">
                            @if (config("pages.parameters.param1") == "register")
                            {{ Translator:: phrase("register") }}
                            @elseif(config("pages.parameters.param1") == "short-course-request")
                            {{ Translator:: phrase(config("pages.form.role").'.short_course_request') }}
                            @else
                            {{ Translator:: phrase(config("pages.form.role").'.request') }}
                            @endif

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
                    <div class="modal-footer">
                        <div class="col">
                            <div class="row">
                                <div class="{{count($listData) > 1 ? "col-md-8":"col-md-12"}}">
                                    <a href="" name="scrollTo"></a>
                                    @if (config("pages.parameters.param1") == "view")
                                    <a class="btn btn-primary ml-auto" target="_blank"
                                        href="{{str_replace("view","print",config("pages.form.data.action.view"))}}">
                                        <i class="fas fa-print"></i>
                                        {{ Translator:: phrase("print") }}
                                    </a>
                                    @elseif (config("pages.parameters.param1") == "account")
                                        @if (!config("pages.form.data.account"))
                                        <button class="btn btn-primary ml-auto float-right" type="submit">
                                            {{ Translator:: phrase("create") }}
                                        </button>
                                        @endif
                                    @else
                                    <button class="btn btn-primary ml-auto float-right" type="submit">
                                        @if (config("pages.form.role") == "add")
                                        @if (Auth::user()->role_id == 6)
                                        {{ Translator:: phrase("request") }}
                                        @else
                                        {{ Translator:: phrase("save") }}
                                        @endif

                                        @elseif(config("pages.form.role") == "edit")
                                        {{ Translator:: phrase("update") }}
                                        @elseif(config("pages.form.role") == "view")
                                        {{ Translator:: phrase("goto.edit") }}
                                        @endif
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
