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
                    @if (Auth::user()->role_id != 2)
                    <th data-type="text" data-key="institute.short_name" width="1" class="sort" data-sort="institute">
                        {{Translator::phrase("institute")}}​</th>
                    @endif
                    <th data-type="text" data-key="study_program.name" width="1" class="sort" data-sort="study_program">
                        {{Translator::phrase("study_program")}}
                    </th>
                    <th data-type="text" data-key="study_course.name" width="1" class="sort" data-sort="study_course">
                        {{Translator::phrase("study_course")}}
                    </th>
                    {{-- <th data-type="text" data-key="study_generation.name" width="1" class="sort" data-sort="study_generation">
                                {{Translator::phrase("study_generation")}}
                    </th> --}}
                    <th data-type="text" data-key="study_academic_year.name" width="1" class="sort"
                        data-sort="study_academic_year">
                        {{Translator::phrase("study_academic_year")}}
                    </th>
                    <th data-type="text" data-key="study_semester.name" width="1" class="sort"
                        data-sort="study_semester">
                        {{Translator::phrase("study_semester")}}
                    </th>
                    <th data-type="text" data-key="study_session.name" width="1" class="sort" data-sort="study_session">
                        {{Translator::phrase("study_session")}}
                    </th>
                    <th data-type="text" data-key="status" width="1" class="sort" data-sort="status">
                        {{Translator::phrase("status")}}
                    </th>
                    <th width=1 data-type="image" data-key="photo">{{Translator::phrase("photo")}}​</th>
                    <th width=1 data-type="option" data-key="view,edit,approve">
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

                    <a data-toggle="modal-ajax" data-target="#modal" id="btn-option-approve" class="dropdown-item">
                        <i class="fas fa-check-circle"></i>
                        {{Translator::phrase("approve")}}
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="d-none dropdown-item sweet-alert-reload" data-toggle="sweet-alert" id="btn-option-delete"
                        data-sweet-alert="confirm" data-sweet-id="" href="">
                        <i class="fas fa-trash"></i> {{Translator::phrase("delete")}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
