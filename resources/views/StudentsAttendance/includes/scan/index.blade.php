<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="row flex-lg-row flex-md-row flex-sm-row-reverse flex-xs-row-reverse">
                    <div class="col-6 col-lg-6 col-xs-12">
                        <div class="card">
                            <div class="card-header">
                            <h5 class="h3 mb-0">{{Translator::phrase("scaned")}}</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush list my--3" id="scaned">
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-6 col-xs-12">
                        <div class="card bg-dark m-0">
                            <div class="card-body">
                                <form role="" class="needs-validation" novalidate="" method="POST"
                                    action="{{config("pages.form.action.detect")}}" id="form-"
                                    enctype="multipart/form-data" style="height: 100%;display: contents;">
                                    @csrf
                                    <div data-toggle="qrcode-reader" data-url="{{config("pages.form.action.detect")}}" data-target="#scaned"
                                        class="text-center"
                                        data-camera-error="{{Translator::phrase("there_was_a_problem_with_your_camera.<br>.no_cameras_found")}}">
                                        <div class="please_wait"
                                            style="position: absolute;    z-index: 1;    top: 50%;    left: 50%;    font-size: 1.5rem;    font-weight: 600;    color: white;    user-select: none;    transform: translate(-50%, -50%);">
                                            {{Translator::phrase("please_wait")}}
                                        </div>
                                        <div class="text-right">
                                            <button disabled type="button" class="btn btn-success" id="btn-open">
                                                {{Translator::phrase("Open")}}
                                            </button>
                                            <button type="button" class="btn btn-danger" id="btn-close">
                                                {{Translator::phrase("Close")}}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="message"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
