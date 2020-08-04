
<div id="post-link" class="collapse">
    <hr class="my-2">
    <div class="form-group mb-2">
        <div class="input-group input-group-sm input-group-merge">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-link"></i></span>
            </div>
            <input class="form-control form-control-sm" type="text" name="link" data-toggle="link"
                data-url="{{str_replace("post","link",config("pages.form.action.detect"))}}" data-target="#link-view"
                placeholder="{{Translator::phrase("link")}}">
        </div>
        <div id="link-view">
            <div class="card m-0">
                <div class="card-header py-1 d-none">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="small_image" name="link_view" class="custom-control-input active" value="1"
                            checked data-target="#small-image">
                        <label class="custom-control-label" for="small_image">
                            {{Translator::phrase("small_image")}}
                        </label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="big_image" name="link_view" class="custom-control-input" value="2"
                            data-target="#big-image">
                        <label class="custom-control-label" for="big_image">
                            {{Translator::phrase("big_image")}}
                        </label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline d-none">
                        <input type="radio" id="show_video" name="link_view" class="custom-control-input" value="3"
                            data-target="#show-video">
                        <label class="custom-control-label"
                            for="show_video">{{Translator::phrase("show_video")}}</label>
                    </div>
                </div>
                <div class="tab-content p-0 border-0">
                    <div id="small-image" class="tab-pane fade" role="tabpanel"
                        aria-labelledby="small-image-tab">
                        <div class="card-body p-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <a href="" target="_blank">
                                        <img data-src="" alt="" class="image" width="200px"
                                            height="200px">
                                    </a>
                                </div>
                                <div class="col ml--2">
                                    <h4 class="mb-0">
                                        <a href="" target="_blank" class="title"></a>
                                    </h4>
                                    <p class="text-sm text-muted mb-0 description"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="big-image" class="tab-pane fade" role="tabpanel" aria-labelledby="big-image-tab">
                        <div class="card-body p-0">
                            <a href="" target="_blank">
                                <img data-src="" alt="" class="image w-100">
                            </a>
                            <div class="row align-items-center">
                                <div class="col mt-2">
                                    <h4 class="mb-0">
                                        <a href="" target="_blank" class="title"></a>
                                    </h4>
                                    <p class="text-sm text-muted mb-0 description"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="show-video" class="tab-pane fade" role="tabpanel" aria-labelledby="show-video-tab">
                        <div class="card-body p-0"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
