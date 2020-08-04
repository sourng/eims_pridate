<div class="row">
    <div class="col-8 offset-2">
        <div class="card">
            @include(config("pages.parent").".includes.modal")
            <div class="table-responsive py-4">
                <table class="table table-flush" id="datatable-basic">
                    <thead class="thead-light">
                        <tr>
                            <th>
                                <div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" id="chk-all" type="checkbox">
                                        <label class="custom-control-label" for="chk-all"></label>
                                    </div>
                                </div>
                            </th>
                            <th>{{Translator::phrase("numbering")}}​</th>
                            <th>{{Translator::phrase("study_course")}}​</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($response["success"])
                        @foreach ($response["data"] as $row)
                        <tr data-id="{{$row["id"]}}" class="clickable" data-toggle="collapse" data-target="#group-of-rows-{{$row["id"]}}" aria-expanded="false" aria-controls="group-of-rows-{{$row["id"]}}">
                            <th>
                                <div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" id="chk-{{$row["id"]}}" type="checkbox">
                                        <label class="custom-control-label" for="chk-{{$row["id"]}}"></label>
                                    </div>
                                </div>
                            </th>
                            <td> {{$row["study_course"]["id"]}} </td>
                            <td> {{$row["study_course"]["name"]}} </td>


                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a data-toggle="modal-ajax" data-target="#modal" class="dropdown-item" href="{{$row["action"]["view"]}}">
                                            <i class="fas fa-eye"></i> {{Translator::phrase("view")}}
                                        </a>

                                        <a data-toggle="modal-ajax" data-target="#modal" class="dropdown-item" href="{{$row["action"]["edit"]}}">
                                            <i class="fas fa-edit"></i> {{Translator::phrase("edit")}}</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" data-toggle="sweet-alert" data-sweet-alert="confirm" data-sweet-id="{{$row["id"]}}" href="{{$row["action"]["delete"]}}">
                                            <i class="fas fa-trash"></i> {{Translator::phrase("delete")}}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <div class="table-responsive py-4">
                            <table class="table table-bordered" id="datatable-basic1">
                                <tbody>
                                    @foreach ($row["generations"] as $gen)
                                    <tr>
                                        <td>
                                            {{$gen["generation"]["name"]}}
                                        </td>
                                    </tr>

                                    @endforeach

                                    @foreach ($row["generations"] as $gen)
                                    <tr>
                                        <td>
                                            <div class="table-responsive py-4" {{$gen["generation"]["name"]}}>
                                                <table class="table table-bordered" id="datatable-basic1">
                                                    <tbody>
                                                        @foreach ($gen["academic_years"] as $aca)
                                                        <tr>
                                                            <td>
                                                                {{$aca["study_academic_year"]["name"]}}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @foreach ($gen["academic_years"] as $aca)
                                                        <tr>
                                                            <td>
                                                                <div class="table-responsive py-4">
                                                                    <table class="table table-bordered" id="datatable-basic1">
                                                                        <tbody>
                                                                            @foreach ($aca["semesters"] as $sem)
                                                                            <tr>
                                                                                <td>
                                                                                    {{$sem["semester"]["name"]}}
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                            @foreach ($aca["semesters"] as $sem)
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="table-responsive py-4">
                                                                                        <table class="table table-bordered" id="datatable-basic1">
                                                                                            <thead>
                                                                                                <th></th>
                                                                                                <th></th>
                                                                                                @foreach($days["data"] as $day)
                                                                                                <th>
                                                                                                    {{$day["name"]}}
                                                                                                </th>
                                                                                                @endforeach
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @php
                                                                                                function gets($days)
                                                                                                {
                                                                                                foreach ($days as $key => $day) {
                                                                                                # code...
                                                                                                }
                                                                                                return '<tr></tr>';
                                                                                                }
                                                                                                @endphp
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        <td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                        @else
                        <tr>
                            <td>{{ $response["message"] }}</td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
