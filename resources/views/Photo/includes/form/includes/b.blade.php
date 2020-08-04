<div class="col-xl-6 col-sm-12 col-xs-12">
    <div class="sticky-top" data-spy="affix" data-offset-top="100">
        <div class="card">
            <div class="card-header">
                <div class="font-weight-600">{{Translator::phrase("edit.photo")}}</div>
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
                    <div class="col-md-12 text-center">
                        <div data-toggle="photo-crop" data-type="square" id="photo-crop" data-update="img#crop-image"
                            data-src="{{config("pages.form.data.photo"). '?type=original'}}"
                            data-viewport-width="100"
                            data-viewport-height="120">
                            <input type="file" id="photo" name="photo" value="">
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
