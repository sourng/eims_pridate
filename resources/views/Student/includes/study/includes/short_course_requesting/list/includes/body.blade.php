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
                                data-checked-show-controls='["edit","delete"]' type="checkbox">
                            <label class="custom-control-label" for="table-check-all"></label>
                        </div>
                    </th>
                    <th width=1 data-type="text" data-key="id" width="1" class="sort" data-sort="id">
                        {{Translator::phrase("numbering")}}​</th>

                    <th width=1 data-type="text" data-key="id">
                        {{Translator::phrase("id.request_study")}}​
                    </th>


                    <th data-type="text" data-key="institute.short_name" width="1" class="sort" data-sort="institute">
                        {{Translator::phrase("institute")}}​</th>

                    <th data-type="text-image" data-key="study_subject.name" data-url="study_subject.image" width="1" class="sort"
                        data-sort="study_subject">
                        {{Translator::phrase("study_subject")}}
                    </th>

                    <th data-type="text" data-key="study_session.name" width="1" class="sort" data-sort="study_session">
                        {{Translator::phrase("study_session")}}
                    </th>

                    <th data-type="text" data-key="status" width="1" class="sort" data-sort="status">
                        {{Translator::phrase("status")}}
                    </th>

                    <th width=1 data-type="image" data-key="photo">{{Translator::phrase("photo")}}​</th>

                    <th width=1 data-type="option" data-key="edit,delete">
                    </th>

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
                    <a data-toggle="modal-ajax" data-target="#modal" id="btn-option-view" class="disabled dropdown-item" href="">
                        <i class="fas fa-eye"></i> {{Translator::phrase("view")}}
                    </a>

                    <a data-toggle="modal-ajax" data-target="#modal" id="btn-option-edit" class="dropdown-item">
                        <i class="fas fa-edit"></i>
                        {{Translator::phrase("edit")}}
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
