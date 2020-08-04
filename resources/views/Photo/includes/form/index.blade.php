<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card-wrapper">
            <form role="photo" action="{{config("pages.form.data.action.photo")}}" method="POST" id="form-photo-make">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="card p-0">
                    <div class="card-header">
                        <h5 class="h3 mb-0">
                            {{ Translator:: phrase("photo") }}
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="{{count($listData) <= 1 ? "col-md-12":"col-md-8"}}" data-list-group>
                                <div class="row">
                                    @include(config("pages.parent").".includes.form.includes.a")
                                    @include(config("pages.parent").".includes.form.includes.b")
                                </div>
                            </div>

                            @if (count($listData) > 1)
                            <div class="col-md-4">
                                <div class="card sticky-top">
                                    <div class="card-header py-2 px-3">
                                        <label
                                            class="label-arrow label-primary label-arrow-right label-arrow-left w-100">
                                            {{Translator::phrase("list")}}
                                        </label>
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="list-group list-group-flush">
                                            @foreach ($listData as $list)

                                            <a href="{{$list["action"]["photo"]}}" data-toggle="list-group"
                                                class="list-group-item list-group-item-action p-2 {{ config("pages.form.data.id") == $list["id"] ? "active" : null}}">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <img data-src="{{$list["image"]}}"
                                                            class="avatar avatar-xs rounded-0">
                                                    </div>
                                                    <div class="col ml--2 p-0">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="text-sm font-weight-500 title">{{$list["name"]}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col">
                            <div class="row">
                                <div class="{{count($listData) > 1 ? "col-md-8":"col-md-12"}}">
                                    @if (!request()->ajax())
                                    <a href="{{url(config("pages.host").config("pages.path").config("pages.pathview")."list")}}"
                                        class="btn btn-default" type="button">{{ Translator:: phrase("back") }}</a>
                                    @endif
                                    <a href="" name="scrollTo"></a>
                                    <button
                                        class="btn btn-primary ml-auto float-right {{config("pages.form.role") == "view"? "d-none": ""}}"
                                        type="submit">
                                        {{ Translator:: phrase("update") }}

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
