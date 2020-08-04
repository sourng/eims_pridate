<div class="card-header">
    <h4>
        {{$formData["study_course_session"]["name"]}}
    </h4>
    <div class="float-right">
        {{$formData["study_course_session"]["study_start"]}} &#9866;
        {{$formData["study_course_session"]["study_end"]}}
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-xs" data-toggle="course-routine">
            <thead>
                <th width=1 class="font-weight-bold">
                    {{Translator::phrase("time")}}
                </th>

                @foreach ($days["data"] as $day)
                <th width=170 class="font-weight-bold">
                    {{$day["name"]}}
                </th>
                @endforeach
            </thead>
            <tbody>
                @foreach ($formData["children"] as $routine)
                <tr>
                    <td>
                        <div class="d-flex">
                            <span>
                                {{$routine["times"]["start_time"]}} &#9866;
                                {{$routine["times"]["end_time"]}}
                            </span>
                        </div>
                    </td>
                    @foreach ($routine["days"] as $d)
                    @if ($d["teacher"])
                    <td class="text-center"
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
