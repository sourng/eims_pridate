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
                                data-checked-show-controls='["view","edit","photo","qrcode","card","certificate","delete"]'
                                type="checkbox">
                            <label class="custom-control-label" for="table-check-all"></label>
                        </div>
                    </th>
                    <th width=1 data-type="text" data-key="id" width="1" class="sort" data-sort="id">
                        {{Translator::phrase("numbering")}}​</th>

                    <th width=1 data-type="text" data-key="name">
                        {{Translator::phrase("name")}}​
                    </th>
                    <th width=1 data-type="text" data-key="study_course_session.name">
                        {{Translator::phrase("course")}}​
                    </th>
                    <th width=1 data-type="icon" data-icon="fas fa-check-circle" data-color="text-green"
                        data-key="account">
                        {{Translator::phrase("account")}}​
                    </th>
                    {{-- <th width=1 data-type="icon" data-icon="fas fa-check-circle" data-color="text-green" data-key="qrcode">
                                {{Translator::phrase("qrcode")}}​
                    </th>
                    <th width=1 data-type="icon" data-icon="fas fa-check-circle" data-color="text-green"
                        data-key="card">
                        {{Translator::phrase("card")}}​
                    </th> --}}
                    <th width=1 data-type="image" data-key="photo">{{Translator::phrase("photo")}}​</th>
                    <th width=1 data-type="option" data-key="view,edit,delete,photo,qrcode,card,certificate">
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
                    <a data-toggle="modal-ajax" data-target="#modal" id="btn-option-view" class="dropdown-item" href="">
                        <i class="fas fa-eye"></i> {{Translator::phrase("view")}}
                    </a>

                    <a data-toggle="modal-ajax" data-target="#modal" id="btn-option-edit" class="dropdown-item">
                        <i class="fas fa-edit"></i>
                        {{Translator::phrase("edit")}}
                    </a>


                    <div class="dropdown-divider"></div>
                    <a href="#" data-toggle="modal-ajax" data-target="#modal" id="btn-option-photo"
                        class="dropdown-item">
                        <i class="fas fa-portrait "></i>
                        {{Translator::phrase("photo")}}
                    </a>
                    <a href="#" data-toggle="modal-ajax" data-target="#modal" id="btn-option-qrcode"
                        class="dropdown-item">
                        <i class="fas fa-qrcode "></i>
                        {{Translator::phrase("qrcode")}}
                    </a>
                    <a href="#" data-toggle="modal-ajax" data-target="#modal" id="btn-option-card"
                        class="dropdown-item">
                        <i class="fas fa-id-card "></i>
                        {{Translator::phrase("card")}}
                    </a>

                    <a href="#" data-toggle="modal-ajax" data-target="#modal" id="btn-option-certificate"
                        class="dropdown-item">
                        <i class="fas fa-file-certificate"></i>
                        {{Translator::phrase("certificate")}}
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
