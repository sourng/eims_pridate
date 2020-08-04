
    <div class="sticky-top" data-spy="affix" data-offset-top="100">
        <div class="card m-0">
            <div class="card-header">
                <div class="font-weight-600">{{Translator::phrase("edit.qrcode")}}</div>
                <div class="list-group list-group-flush">
                    <div href="#" class="list-group-item">
                        <div class="row">
                            <div class="avatar avatar-xl rounded">
                                <img data-src="{{config("pages.form.data.photo"). '?type=original'}}" alt="" id="crop-image">
                            </div>
                            <div class="col ml--2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="mb-0 text-sm">
                                            {{config("pages.form.data.name")}}
                                        </h4>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">
                                    {{config("pages.form.data.study_course_session.name")}}
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body text-center">
                <div class="row">
                    <div class="col mb-3">
                        @if (config("pages.form.data") == null)
                        <div class="text-danger text-center">
                            {{Translator::phrase('no_date')}}
                        </div>
                        @endif
                        <style>
                            [data-toggle="qrcode"] {
                                height: 250px;
                            }

                            [data-toggle="qrcode"] canvas {
                                border: 10px solid #fff;
                                text-align: center;
                                align-items: center;
                                margin: 50px auto;
                            }
                        </style>
                        <div id="qrcode-container" class="bg-dark py-2" data-toggle="qrcode"
                            data-text="{{config("pages.form.data.qrcode_url")}}"
                            data-image="{{config("pages.form.data.photo")}}"></div>

                        <div class="input-slider-container mt-3 ">
                            <div id="input-slider-qrcode" data-orientation="horizontal" class="input-slider"
                                data-range-value-min="50" data-toggle="qrcode-size" data-target="div#qrcode-container"
                                data-range-value-max="100"></div>
                            <div class="row mt-3">
                                <div class="col-12 pull-right text-right">
                                    <span id="input-slider-value" class="range-slider-value"
                                        data-range-value-low="90"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
