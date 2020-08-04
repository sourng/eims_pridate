<div class="card-body p-0" >
    <div class="row">
        <div class="{{count($listData) <= 1 ? "col-md-12":"col-md-8"}}" data-list-group>
            @if (config("pages.parameters.param1") == "view")
            @include(config("pages.parent").".includes.view.includes.a")
            @include(config("pages.parent").".includes.view.includes.b")
            @else
            @include(config("pages.parent").".includes.form.includes.a")
            @endif

        </div>
        @if (count($listData) > 1)
        <div class="col-md-4">
            <div class="card sticky-top">
                <div class="card-header py-2 px-3">
                    <label class="label-arrow label-primary label-arrow-right label-arrow-left w-100">
                        {{Translator::phrase("list")}}
                    </label>
                </div>
                <div class="card-body p-2">
                    <div class="list-group list-group-flush">
                        @foreach ($listData as $list)
                        <a href="{{$list["action"][config("pages.form.role")]}}" data-toggle="list-group"
                            class="list-group-item list-group-item-action p-2 {{ config("pages.form.data.id") == $list["id"] ? "active" : null}}">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img data-src="{{$list["image"]}}" class="avatar avatar-xs rounded-0">
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
