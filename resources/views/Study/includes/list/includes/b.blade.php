<div class="card-body p-0">
    <div class="table-responsive" data-toggle="list" data-list-values='["id", "name"]'>
        <table id="list-table" class="table border">
            <thead class="thead-light">
                <tr>
                    <th width="1">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="table-check-all" data-toggle="table-checked"
                                data-checked-controls="table-checked"
                                data-checked-show-controls='["view","edit","delete"]' type="checkbox">
                            <label class="custom-control-label" for="table-check-all"></label>
                        </div>
                    </th>
                    <th width="1" class="sort" data-sort="id">{{Translator::phrase("numbering")}}​</th>
                    <th class="sort" data-sort="name">
                        {{Translator::phrase(str_replace("-","_",config("pages.form.name")))}}​</th>
                    <th>{{Translator::phrase("description")}}​</th>
                    <th width="1">{{Translator::phrase("image")}}​</th>
                    <th width="1" class="d-none"></th>
                </tr>
            </thead>
            <tbody class="list">
                @if ($response["success"])
                @foreach ($response["data"] as $row)
                <tr data-id="{{$row["id"]}}">
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" data-toggle="table-checked"
                                id="table-check-{{$row["id"]}}" data-checked-show-controls='["view","edit","delete"]'
                                type="checkbox" data-checked="table-checked" value="{{$row["id"]}}">
                            <label class="custom-control-label" for="table-check-{{$row["id"]}}"></label>
                        </div>
                    </td>
                    <td class="id">{{$row["id"]}}</td>
                    <td class="name"> {{$row["name"]}}</td>
                    <td>
                        @if ($row["description"])
                        {{  $row["description"]}}
                        @else
                        {{-- <span class="text-red"> {{ Translator::phrase("empty")}}</span> --}}
                        @endif

                    </td>
                    <td> <img width="50px" height="50px" data-src="{{$row["image"]}}" alt=""></td>

                    <td class="d-none text-right">
                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a data-toggle="modal-ajax" data-target="#modal" class="dropdown-item"
                                    href="{{$row["action"]["view"]}}">
                                    <i class="fas fa-eye"></i> {{Translator::phrase("view")}}
                                </a>

                                <a data-toggle="modal-ajax" data-target="#modal" class="dropdown-item"
                                    href="{{$row["action"]["edit"]}}">
                                    <i class="fas fa-edit"></i> {{Translator::phrase("edit")}}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" data-toggle="sweet-alert" data-sweet-alert="confirm"
                                    data-sweet-id="{{$row["id"]}}" href="{{$row["action"]["delete"]}}">
                                    <i class="fas fa-trash"></i> {{Translator::phrase("delete")}}</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="5" class="text-center p-3">
                        <p class="m-0"><svg width="64" height="41" viewBox="0 0 64 41"
                                xmlns="http://www.w3.org/2000/svg">
                                <g transform="translate(0 1)" fill="none" fill-rule="evenodd">
                                    <ellipse fill="#F5F5F5" cx="32" cy="33" rx="32" ry="7"></ellipse>
                                    <g fill-rule="nonzero" stroke="#D9D9D9">
                                        <path
                                            d="M55 12.76L44.854 1.258C44.367.474 43.656 0 42.907 0H21.093c-.749 0-1.46.474-1.947 1.257L9 12.761V22h46v-9.24z">
                                        </path>
                                        <path
                                            d="M41.613 15.931c0-1.605.994-2.93 2.227-2.931H55v18.137C55 33.26 53.68 35 52.05 35h-40.1C10.32 35 9 33.259 9 31.137V13h11.16c1.233 0 2.227 1.323 2.227 2.928v.022c0 1.605 1.005 2.901 2.237 2.901h14.752c1.232 0 2.237-1.308 2.237-2.913v-.007z"
                                            fill="#FAFAFA"></path>
                                    </g>
                                </g>
                            </svg></p>
                        <span>{{ $response["message"] }}</span>
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>
</div>
