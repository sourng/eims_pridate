<div class="card-body p-0">
    <div class="table-responsive py-4">
        <table
            data-url="{{str_replace("add","list-datatable",config("pages.form.action.add"))}}{{config("pages.search")}}"
            class="table table-flush" data-toggle="datatable-ajax">
            <thead class="thead-light">
                <tr>
                    <th data-type="checkbox" data-key="null" width="1">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="table-check-all" data-toggle="table-checked"
                                data-checked-controls="table-checked"
                                data-checked-show-controls='["view","edit","delete"]' type="checkbox">
                            <label class="custom-control-label" for="table-check-all"></label>
                        </div>
                    </th>
                    <th width=1 data-type="text" data-key="id" width="1" class="sort" data-sort="id">
                        {{Translator::phrase("numbering")}}​</th>

                    <th width=1 data-type="text" data-key="name">
                        {{Translator::phrase("name")}}​
                    </th>
                    <th width=1 data-type="text" data-key="layout">
                        {{Translator::phrase("layout")}}​
                    </th>
                    <th width=1 data-type="image" data-key="front,background">{{Translator::phrase("frame")}}​
                    </th>
                    <th width=1 data-type="icon" data-key="status">{{Translator::phrase("status")}}​</th>
                    <th width=1 data-type="option" data-key="view,edit,set,delete"></th>

                </tr>
            </thead>
        </table>
        <div class="d-none" id="datatable-ajax-option">
            <div class="dropdown">
                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a data-toggle="modal-ajax" data-target="#modal" id="btn-option-view" class="dropdown-item" href="">
                        <i class="fas fa-eye"></i> {{Translator::phrase("view")}}
                    </a>

                    <a data-toggle="modal-ajax" data-target="#modal" id="btn-option-edit" class="dropdown-item" href="">

                        <i class="fas fa-edit"></i> {{Translator::phrase("edit")}}</a>

                    <a href="#" data-toggle="card-frame" data-id="" id="btn-option-set"
                        data-title="{{Translator::phrase("set.as.default")}}" data-text="name"
                        data-confirm-button-text="{{Translator::phrase("set")}}"
                        data-cancel-button-text="{{Translator::phrase("cancel")}}"
                        data-text-select="{{ Translator::phrase("select") }}"
                        data-text-selected="{{ Translator::phrase("selected") }}" data-image="front_o,background_o"
                        data-link="" class="dropdown-item">
                        <i class="fas fa-check-square"></i>
                        {{Translator::phrase("set.as.default")}}

                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item sweet-alert-reload" data-toggle="sweet-alert" id="btn-option-delete"
                        data-sweet-alert="confirm" data-sweet-id="" href="">
                        <i class="fas fa-trash"></i> {{Translator::phrase("delete")}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
