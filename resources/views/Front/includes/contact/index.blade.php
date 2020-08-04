<div class="col-12">
    <h1 class="my-2 h2">{{Translator::phrase("contact")}}</h1>
    <hr class="my-2">
    <div class="container">
        <div class="row bg-light pt-3 pb-3 mb-3">
            <div class="col-12">
                {{Translator::phrase("address")}}
            </div>
            <div class="col-4">
                <span class="text-sm">
                    {{config("app.address")}}
                </span>
            </div>
            <div class="col-lg-4 col-4">
                <p class="m-0 text-sm">
                    <i class="fa fa-phone-square" aria-hidden="true"></i>
                    {{config("app.phone")}}
                </p>
                <p class="m-0 text-sm">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    {{config("app.email")}}
                </p>
            </div>
        </div>
        <div class="row bg-light pt-3 pb-3 mb-3">
            <div class="col-lg-6 col-12">
                <div style="width: 100%">
                    <div id="map-custom" class="map-canvas" data-title="{{config("app.name")}}" data-lat="13.362523"
                        data-lng="103.869508" data-maptype="ROADMAP" data-mapzoom="18" data-mousescroll="false"
                        style="height: 400px;">
                    </div>
                    <div class="info-map-content d-none">
                        <div class="info-window-content">
                            <h2>{{config("app.name")}}</h2>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <form class="needs-validation" novalidate="" method="POST"
                    action="{{config("pages.form.action.detect")}}" id="form-{{config("pages.form.name")}}"
                    enctype="multipart/form-data" data-validate="{{json_encode(config('pages.form.validate'))}}">
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input class="form-control " placeholder="{{Translator::phrase("name")}}" type="text"
                                value="" name="name" autocomplete="name">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input class="form-control " placeholder="{{Translator::phrase("email")}}" type="email"
                                value="" name="email" autocomplete="email">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input class="form-control " placeholder="{{Translator::phrase("phone")}}" type="phone"
                                value="" name="phone" autocomplete="phone">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope-open-text"></i></span>
                            </div>
                            <textarea class="form-control" id="" name="message"
                                placeholder="{{Translator::phrase("message")}}"></textarea>
                        </div>
                    </div>
                    <button type="submit"
                        class="btn float-right btn-primary">{{Translator::phrase("send_message")}}</button>
                </form>
            </div>

        </div>
    </div>

</div>
