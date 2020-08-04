<div class="col">
    <div class="modal fade" id="mailbox-compose" tabindex="-1" role="dialog" aria-labelledby="add_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <form role="{{config("pages.form.role")}}" class="needs-validation" method="POST"
                action="{{str_replace("/add","compose",config("pages.form.action.add"))}}" id="form-mailbox"
                data-toggle="mailbox-compose" enctype="multipart/form-data"
                data-validation="{{json_encode(config('pages.form.validate'))}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" class="h3 mr-2">
                            {{ Translator:: phrase("compose") }}
                        </h6>
                        <a href="{{str_replace("/add","compose",config("pages.form.action.add"))}}" target="_blank"
                            class="full-link"><i class="fas fa-external-link"></i> </a>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body p-0">
                        <div class="card m-0">
                            <div class="card-body">
                                {{-- @if (request()->ajax()) --}}
                                @include(config("pages.parent").".includes.modal.includes.a")
                                {{-- @endif --}}

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer {{config("pages.form.role") == "view"? "invisible": ""}}">
                        <div class="col">
                            <div class="row">
                                <div class="{{count($listData) > 1 ? "col-md-8":"col-md-12"}}">
                                    <a href="" name="scrollTo"></a>
                                    <button class="btn btn-primary ml-auto float-right" type="submit">

                                        {{ Translator:: phrase("send_message") }}

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="mailbox-compose-link" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h6 class="modal-title" class="h3 mr-2">Insert Link</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col mb-3">
                        <div class="form-group">
                            <label class="form-control-label mb-0" for="url">{{Translator::phrase("url")}}</label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                </div>
                                <input class="form-control" data-placeholder="{{Translator::phrase("url")}}" type="url"
                                    id="url">
                            </div>
                        </div>
                    </div>
                    <div class="col mb-3">
                        <div class="form-group">
                            <label class="form-control-label mb-0"
                                for="text_to_display">{{Translator::phrase("text_to_display")}}</label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-font-case"></i></span>
                                </div>
                                <input class="form-control" data-placeholder="{{Translator::phrase("text_to_display")}}"
                                    type="text" id="text_to_display">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button id="btn-remove" class="btn btn-danger">{{Translator::phrase("remove")}}</button>
                    <button type="button" class="btn" data-dismiss="modal"
                        aria-label="Close">{{Translator::phrase("cancel")}}</button>
                    <button id="btn-save" class="btn btn-primary">{{Translator::phrase("ok")}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mailbox-compose-image" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h6 class="modal-title" class="h3 mr-2">Insert Image</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" data-toggle="tab" href="#nav-link" role="tab"
                                aria-controls="nav-link" aria-selected="true">Link</a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#nav-upload" role="tab"
                                aria-controls="nav-upload" aria-selected="true">Upload</a>
                        </div>
                    </nav>

                    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-link" role="tabpanel"
                            aria-labelledby="nav-link-tab">
                            <div class="col mb-3">
                                <div class="form-group">
                                    <label class="form-control-label mb-0"
                                        for="url">{{Translator::phrase("image.url")}}</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control"
                                            data-placeholder="{{Translator::phrase("image.url")}}" type="url" id="url">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-upload" role="tabpanel" aria-labelledby="nav-upload-tab">
                            <div class="col mb-3">
                                <div class="form-group">
                                    <label class="form-control-label mb-0"
                                        for="url">{{Translator::phrase("upload.image")}}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="upload" data-name="image"
                                            data-url="{{str_replace("/add","upload",config("pages.form.action.add"))}}">
                                        <label id="onprogress" class="custom-file-label"
                                            for="upload">{{Translator::phrase("browse")}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bt-3" id="preview-image"></div>
                </div>

                <div class="modal-footer border-top">
                    <button type="button" class="btn" data-dismiss="modal"
                        aria-label="Close">{{Translator::phrase("cancel")}}</button>
                    <button id="btn-save" class="btn btn-primary">{{Translator::phrase("ok")}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
