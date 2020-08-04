<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card-wrapper">
            <form role="account" action="{{config("pages.form.action.detect")}}" method="POST" id="form-create-account"
                data-validate="{{json_encode(config('pages.form.validate'))}}">
                @csrf
                <div class="card p-0">
                    <div class="card-header">
                        <h5 class="h3 mb-0">
                            {{ Translator:: phrase("create_account") }}
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="{{count($listData) <= 1 ? "col-md-8 offset-2":"col-md-8"}}" data-list-group>

                                @include(config("pages.parent").".includes.account.includes.a")

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

                                            <a href="{{$list["action"]["account"]}}" data-toggle="list-group"
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
                                        class="btn btn-primary ml-auto float-right {{config("pages.form.data.account") || config("pages.form.role") == "view"? "d-none": ""}}"
                                        type="submit">
                                        @if (config("pages.parameters.param2") == "create")
                                        {{ Translator:: phrase("create") }}
                                        @else
                                        {{ Translator:: phrase("update") }}
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
</div>
