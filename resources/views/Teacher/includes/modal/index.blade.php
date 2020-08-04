<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="add_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <form role="{{config("pages.form.role")}}" class="needs-validation" novalidate="" method="POST"
            action="{{config("pages.form.action.detect")}}"
            id="{{config("pages.parameters.param1") == "subject-lesson" ? "form-lesson" : "form-".config("pages.form.name")}}"
            enctype="multipart/form-data"
            {{config("pages.parameters.param1") == "subject-lesson" ? "data-validation=" : "data-validate="}}{{json_encode(config("pages.form.validate"))}}>
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" class="h3 mr-2">
                        @if(config("pages.parameters.param1") == "subject-lesson")
                        {{ Translator:: phrase(config("pages.form.role").".lesson") }}
                        @else
                        {{ Translator:: phrase(config("pages.form.role").".".str_replace("-","_",config("pages.form.name"))) }}
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
                <div class="modal-footer {{config("pages.form.role") == "view"? "invisible": ""}}">
                    <div class="col">
                        <div class="row">
                            <div class="{{count($listData) > 1 ? "col-md-8":"col-md-12"}}">
                                <a href="" name="scrollTo"></a>
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
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-qrcode" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <form role="" class="needs-validation" novalidate="" method="POST"
            action="{{config("pages.form.action.detect")}}" id="form-" enctype="multipart/form-data"
            style="height: 100%;display: contents;">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" class="h3 mr-2">
                        {{ Translator:: phrase("add_absent") }}
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
                            <div data-toggle="qrcode-reader" data-url="{{config("pages.form.action.detect")}}"
                                class="text-center"
                                data-camera-error="{{Translator::phrase("there_was_a_problem_with_your_camera.<br>.no_cameras_found")}}">
                                <div class="please_wait"
                                    style="position: absolute;    z-index: 1;    top: 50%;    left: 50%;    font-size: 1.5rem;    font-weight: 600;    color: white;    user-select: none;    transform: translate(-50%, -50%);">
                                    {{Translator::phrase("please_wait")}}</div>
                            </div>
                            <div class="message"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
