<thead class="thead-gray">
    <tr data-height="150">
        <th class="text-center" rowspan="1"
            colspan="{{ DateHelper::daysOfMonth(request("year"),request("month")) + 6 }}" scope="rowgroup">
            <h4 class="header lh-170">
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
                <span>
                    {{ Translator::phrase("list.score.".config("pages.form.data.node_type"))}}
                </span>
            </h4>
        </th>
    </tr>

    <tr>
        <th class="{{isset($no_name) ? "d-none" : ""}} font-weight-bold1">{{  Translator::phrase("numbering") }}​</th>
        <th class="{{isset($no_name) ? "d-none" : ""}} font-weight-bold1">{{  Translator::phrase("name") }}​</th>
        <th class="{{isset($no_name) ? "d-none" : ""}} font-weight-bold1">{{  Translator::phrase("gender") }}​</th>
        @foreach ($response['study_subject'] as $row)
        <th> {{$row['subject']['name'] }}</th>
        @endforeach
        <th class="font-weight-bold1">{{  Translator::phrase("attendance_score") }}​</th>
        <th class="font-weight-bold1">{{  Translator::phrase("other_score") }}</th>
        <th class="font-weight-bold1">{{  Translator::phrase("total") }}</th>
        <th class="font-weight-bold1">{{  Translator::phrase("average") }}</th>
        <th class="font-weight-bold1">{{  Translator::phrase("grade") }}</th>
    </tr>
</thead>
