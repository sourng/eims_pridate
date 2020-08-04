<thead class="thead-gray">
    <tr data-height="100">
        <th class="text-center" rowspan="1"
            colspan="{{count($response['study_subject']) + ((config("pages.parameters.param1") != "report") ? 9 : 8)}}">
            <h4 class="header">
                @if($response["data"])
                <span>
                    {{$response["data"][0]["node"]["study_course_session"]["study_course_schedule"]["study_program"]["name"]}}
                    -
                    {{$response["data"][0]["node"]["study_course_session"]["study_course_schedule"]["study_course"]["name"]}}
                    ({{$response["data"][0]["node"]["study_course_session"]["study_start"]}} &#9866;
                    {{$response["data"][0]["node"]["study_course_session"]["study_end"]}})
                </span>
                <br>
                <span>
                    {{$response["data"][0]["node"]["study_course_session"]["study_course_schedule"]["study_generation"]["name"]}}
                    -
                    {{$response["data"][0]["node"]["study_course_session"]["study_course_schedule"]["study_academic_year"]["name"]}}
                    -
                    {{$response["data"][0]["node"]["study_course_session"]["study_course_schedule"]["study_semester"]["name"]}}
                    -
                    {{$response["data"][0]["node"]["study_course_session"]["study_session"]["name"]}}
                </span>
                <br>
                @endif
                <span>
                    {{ Translator::phrase("list.score.".config("pages.form.data.node_type"))}}
                </span>
            </h4>
        </th>
    </tr>

    <tr>
        <th width="1">
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" id="table-check-all" data-toggle="table-checked"
                    data-checked-controls="table-checked" data-checked-show-controls='["edit","delete"]'
                    type="checkbox">
                <label class="pl-4 custom-control-label" for="table-check-all"></label>
            </div>
        </th>
        <th class="font-weight-bold">{{  Translator::phrase("numbering") }}​</th>
        <th class="font-weight-bold">{{  Translator::phrase("name") }}​</th>
        <th class="font-weight-bold">{{  Translator::phrase("gender") }}​</th>
        @foreach ($response['study_subject'] as $row)
        <th class="font-weight-bold mw"> {{$row['subject']['name'] }}</th>
        @endforeach
    </tr>
</thead>
