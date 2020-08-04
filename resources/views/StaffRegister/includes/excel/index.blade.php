<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card-wrapper">
            <div class="card p-0">
                <div class="card-header">
                    <h5 class="h3 mb-0">
                        បញ្ចូលទិន្នន័យតាមទម្រង់អ៊ីហ្សែល
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="{{count($listData) <= 1 ? "col-md-12":"col-md-10"}}" data-list-group>
                            <div class="row">
                                <div class="col-md-12">
                                    @csrf
                                    @include(config("pages.parent").".includes.excel.includes.a")

                                </div>
                                <div class="col-md-6">
                                    @include(config("pages.parent").".includes.excel.includes.b")
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body overflow-auto bg-dark" style="height: 230px" id="console">
                                            <code></code>
                                        </div>
                                        <button class="btn btn-primary m-0" data-toggle="collapse" data-target="#show-errors">
                                            បង្ហាញទិន្នន័យដែលបញ្ចូលមិនបានជោគជ័យ
                                        </button>
                                        <div class="card-body overflow-auto collapse bg-gray-dark" style="height: 230px" id="show-errors"></div>

                                    </div>

                                </div>

                            </div>

                        </div>
                        @if (count($listData) > 1)
                        <div class="col-md-2">
                            <div class="card sticky-top">
                                <div class="card-header py-2 px-3">
                                    <label class="label-arrow label-primary label-arrow-right label-arrow-left w-100">
                                        {{Translator::phrase("list")}}
                                    </label>
                                </div>
                                <div class="card-body p-2">
                                    <div class="list-group list-group-flush">
                                        @foreach ($listData as $list)
                                        <a href="{{$list["action"][config("pages.form.role")]}}"
                                            data-toggle="list-group"
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
                <a href="{{str_replace("/add","",config("pages.form.action.add"))}}" class="btn btn-default">{{Translator::phrase("back")}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
