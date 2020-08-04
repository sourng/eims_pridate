<div class="col-xl-4 offset-xl-4">
    <div class="card m-0">
        <div class="card-header">
            <div class="list-group list-group-flush">
                <div href="#" class="list-group-item">
                    <div class="row">
                        <div class="avatar avatar-xl rounded">
                            <img data-src="{{config("pages.form.data.profile")}}" alt=""
                                id="crop-image">
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
                                {{config("pages.form.data.institute.name")}}
                            </p>
                            <p class="text-sm mb-0">
                                {{config("pages.form.data.email")}}
                            </p>
                            <p class="text-sm mb-0">
                                {{config("pages.form.data.phone")}}
                            </p>
                            @if(config("pages.form.data.account"))
                            <p class="text-sm mb-0 text-green">
                                {{Translator::phrase("has_account")}}
                                <i class="fas fa-check-circle"></i>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="form-group mb-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                    </div>
                    <input class="form-control " placeholder="{{Translator::phrase("old_password")}}" type="password"
                        value="" name="old_password" required="" autocomplete="old-password">
                </div>
            </div>
            <div class="form-group mb-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                    </div>
                    <input class="form-control " placeholder="{{Translator::phrase("new_password")}}" type="password"
                        value="" name="password" required="" autocomplete="new-password">
                </div>
            </div>
            <div class="form-group mb-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input class="form-control " placeholder="{{Translator::phrase("password_confirm")}}"
                        type="password" value="" name="password_confirmation" required="" autocomplete="new-password">
                </div>
            </div>


        </div>

    </div>
</div>
