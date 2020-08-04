<div class="card-body p-0">
    <div class="table-responsive" data-toggle="list"
        data-list-values='["id", "study_program","study_course","study_generation","study_academic_year","study_semester","study_session","status"]'>
        <table id="request-table" class="table" data-toggle="ajax-table-data">
            <thead class="thead-light">
                <tr>
                    <th data-type="checkbox" data-key="checkbox" width="1">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="table-check-all" data-toggle="table-checked"
                                data-checked-controls="table-checked"
                                {{$response["success"] ? "" : "disabled=disabled"}}
                                data-checked-show-controls='["edit","delete"]' type="checkbox">
                            <label class="custom-control-label" for="table-check-all"></label>
                        </div>

                    </th>
                    <th data-type="text" data-key="id" width="1" class="sort" data-sort="id">{{Translator::phrase("numbering")}}​</th>
                    <th data-type="text" data-key="study_program.name" width="1" class="sort" data-sort="study_program">
                        {{Translator::phrase("study_program")}}
                    </th>
                    <th data-type="text" data-key="study_course.name" width="1" class="sort" data-sort="study_course">
                        {{Translator::phrase("study_course")}}
                    </th>
                    <th data-type="text" data-key="study_generation.name" width="1" class="sort" data-sort="study_generation">
                        {{Translator::phrase("study_generation")}}
                    </th>
                    <th data-type="text" data-key="study_academic_year.name" width="1" class="sort" data-sort="study_academic_year">
                        {{Translator::phrase("study_academic_year")}}
                    </th>
                    <th data-type="text" data-key="study_semester.name" width="1" class="sort" data-sort="study_semester">
                        {{Translator::phrase("study_semester")}}
                    </th>
                    <th data-type="text" data-key="study_session.name" width="1" class="sort" data-sort="study_session">
                        {{Translator::phrase("study_session")}}
                    </th>
                    <th data-type="text" data-key="description">
                        {{Translator::phrase("description")}}
                    </th>
                    <th data-type="text" data-key="status" width="1" class="sort" data-sort="status">
                        {{Translator::phrase("status")}}
                    </th>
                    <th data-type="image" data-key="photo">
                        {{Translator::phrase("photo")}}
                    </th>
                </tr>

            </thead>

            <tbody class="list">
                @if ($response["success"])
                @foreach ($response["data"] as $row)
                <tr data-id="{{$row["id"]}}">
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" data-toggle="table-checked"
                                id="table-check-{{$row["id"]}}" data-checked-show-controls='["edit","delete"]'
                                type="checkbox" data-checked="table-checked" value="{{$row["id"]}}">
                            <label class="custom-control-label" for="table-check-{{$row["id"]}}"></label>
                        </div>

                    </td>
                    <td class="id">{{$row["id"]}}</td>
                    <td class="study_program">
                        {{$row["study_program"]["name"]}}
                    </td>
                    <td class="study_course">
                        {{$row["study_course"]["name"]}}
                    </td>
                    <td class="study_generation">
                        {{$row["study_generation"]["name"]}}
                    </td>
                    <td class="study_academic_year">
                        {{$row["study_academic_year"]["name"]}}
                    </td>
                    <td class="study_semester">
                        {{$row["study_semester"]["name"]}}
                    </td>
                    <td class="study_session">
                        {{$row["study_session"]["name"]}}
                    </td>
                    <td>
                        {{$row["description"]}}
                    </td>
                    <td class="status">
                        {{$row["status"]}}
                    </td>
                    <td>
                        <img data-src="{{$row["photo"]}}" alt="" width="50px">
                    </td>
                </tr>

                @endforeach
                @else
                <tr>
                    <td colspan="10" class="text-center p-3">
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
