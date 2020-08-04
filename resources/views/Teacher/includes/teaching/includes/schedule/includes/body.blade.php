
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-xs table-bordered" data-toggle="course-routine">
            <thead>
                <tr>
                    <th class="text-center" rowspan="1" colspan="8" scope="rowgroup">
                        <h4 class="header lh-170">
                            <span>
                                {{$schedule["study_course_session"]["study_course_schedule"]["study_program"]["name"]}} -
                                {{$schedule["study_course_session"]["study_course_schedule"]["study_course"]["name"]}}
                            </span>
                            <br>
                            <span>
                                {{Translator::phrase("schedule")}}
                                {{$schedule["study_course_session"]["study_course_schedule"]["study_generation"]["name"]}} -
                                {{$schedule["study_course_session"]["study_course_schedule"]["study_academic_year"]["name"]}} -
                                {{$schedule["study_course_session"]["study_course_schedule"]["study_semester"]["name"]}}
                            </span>
                        </h4>
                    </th>
                </tr>
                <tr>
                    <th width=1 class="font-weight-bold">
                        {{Translator::phrase("time")}}
                    </th>
                    @foreach ($days["data"] as $day)
                    <th width=170 class="text-center font-weight-bold">
                        {{$day["name"]}}</th>
                    @endforeach
                </tr>


            </thead>
            <tbody>
                @foreach ($schedule['children'] as $routine)
                <tr>
                    <td>
                        <div class="d-flex">
                            <span>{{$routine["times"]["start_time"]}}</span>
                            &#9866;
                            <span>{{$routine["times"]["end_time"]}}</span>
                        </div>
                    </td>
                    @foreach ($routine["days"] as $d)
                    @if ($d["teacher"])

                    <td class="text-center {{($d["teacher"]["id"] == Auth::user()->node_id)? "text-white bg-".config("app.theme_color.name") : ""}}"
                        data-merge="{{$d["teacher"]["id"]}}-{{$d["study_subject"]["id"]}}-{{$d["study_class"]["id"]}}">
                        <span>
                            {{$d["teacher"]["name"]}}
                            <br>
                            {{$d["teacher"]["email"]}}
                            <br>
                            {{$d["teacher"]["phone"]}}
                        </span>
                        <br>
                        <div class="border">
                            <span>
                                {{$d["study_subject"]["name"]}}
                                <br>
                                {{$d["study_class"]["name"]}}
                            </span>
                        </div>

                    </td>
                    @else
                    <td class="merge"></td>
                    @endif

                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
