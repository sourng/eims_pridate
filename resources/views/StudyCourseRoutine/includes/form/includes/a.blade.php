<style>


    .table-xs td,
    .table-xs th {
        padding: .3rem .07rem !important;
        font-size: .8rem !important;
        text-align: center;
        user-select: none;
        vertical-align: middle;
    }

    table td.cell.selected {
        background-color: #f0f8ff
    }
    .context-menu-icon::before{
        font-family: "context-menu-icons","Font Awesome 5 Pro" !important;
    }
</style>
<div class="card">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            A
        </label>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label class="form-control-label" for="study_course_session">
                    {{ Translator:: phrase("study_course_session") }}

                    @if(array_key_exists("study_course_session",config("pages.form.validate.rules")))
                    <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset"><i
                            class="fas fa-asterisk fa-xs"></i></span>
                    @endif

                </label>

                <select class="form-control" data-toggle="select" id="study_course_session" title="Simple select"

                    data-text="{{ Translator::phrase("add_new_option") }}"
                    data-placeholder="{{ Translator::phrase("choose.study_course_session") }}" name="study_course_session"
                    data-select-value="{{config("pages.form.data.study_course_session.id")}}">
                    @foreach($study_course_session["data"] as $o)
                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-xs table-bordered border" data-toggle="course-routine">
                <thead>
                    <th width=1 class="font-weight-bold">
                        {{Translator::phrase("time")}}
                    </th>
                    @foreach ($days['data'] as $day)
                <th data-name="day[]" data-value="{{$day['id']}}" width=500 class="font-weight-bold">
                        {{$day['name']}}</th>
                    @endforeach

                </thead>
                <tbody>
                    @if(config('pages.form.data'))
                    @foreach (config('pages.form.data.children') as $routine)
                    <tr>
                        <td>
                            <div class="d-flex">
                                <div class="m-1" style="width : 110px">
                                    <input type="time" step="1" name="start_time[]" id="start_time" class="form-control form-control-sm"
                                        value="{{$routine["times"]["start_time"]}}">
                                </div>
                                <div class="m-1" style="width : 110px">
                                    <input type="time" step="1" name="end_time[]" id="end_time" class="form-control form-control-sm"
                                        value="{{$routine["times"]["end_time"]}}">
                                </div>
                            </div>
                        </td>
                        @foreach ($routine["days"] as $d)
                        @if ($d["teacher"])
                        <input type="hidden" name="day[]" value="{{ $d["day"]["id"]}}">
                        <td class="cell" data-merge="{{$d["teacher"]["id"]}}-{{$d["study_subject"]["id"]}}-{{$d["study_subject"]["id"]}}">
                            <div class="m-1">
                                <select class="form-control form-control-sm" data-toggle="select" id="teacher"
                                    title="Simple select"
                                    data-text="{{ Translator::phrase("add_new_option") }}"
                                    data-placeholder="{{ Translator::phrase("choose.teacher") }}" name="teacher[]"
                                    data-select-value="{{$d["teacher"]["id"]}}"
                                    {{(array_key_exists("teacher",config("pages.form.validate.rules"))) ? "required" : ""}}>
                                    @foreach($teacher["data"] as $o)
                                    <option data-src="{{$o["photo"]}}" value="{{$o["id"]}}">
                                        {{ $o["first_name"]}} {{ $o["last_name"]}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="m-1">
                                <select class="form-control form-control-sm" data-toggle="select" id="study_subject"
                                    title="Simple select"

                                    data-text="{{ Translator::phrase("add_new_option") }}"
                                    data-placeholder="{{ Translator::phrase("choose.study_subject") }}"
                                    name="study_subject[]"
                                    data-select-value="{{$d["study_subject"]["id"]}}"
                                    {{(array_key_exists("study_subject",config("pages.form.validate.rules"))) ? "required" : ""}}>
                                    @foreach($study_subject["data"] as $o)
                                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="m-1">
                                <select class="form-control form-control-sm" data-toggle="select" id="study_class"
                                    title="Simple select"
                                    data-placeholder="{{ Translator::phrase("choose.study_class") }}"
                                    name="study_class[]" data-select-value="{{$d["study_class"]["id"]}}"
                                    {{(array_key_exists("study_class",config("pages.form.validate.rules"))) ? "required" : ""}}>
                                    @foreach($study_class["data"] as $o)
                                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option> @endforeach
                                </select>
                            </div>
                        </td>
                        @else
                        <td class="cell merge"></td>
                        @endif

                        @endforeach
                    </tr>
                    @endforeach
                    @else
                    @for ($i = 7; $i < 11; $i++) <tr>
                        <td>
                            <div class="d-flex">
                                <div class="m-1" style="width : 110px">
                                    <input type="time" step="1" name="start_time[]" id="start_time" class="form-control form-control-sm"
                                        value="{{$i< 10 ? "0" : ""}}{{$i}}:30:00">
                                </div>
                                <div class="m-1" style="width : 110px">
                                    <input type="time" step="1" name="end_time[]" id="end_time" class="form-control form-control-sm"
                                        value="{{$i< 9 ? "0" : ""}}{{$i + 1}}:30:00">
                                </div>
                            </div>

                        </td>
                        @for ($day = 1; $day <=7 ; $day++)
                        <td class="cell">
                            <input type="hidden" name="day[]" value="{{$day}}">

                            </td>
                            @endfor
                            </tr>
                            @endfor
                        @endif
                        </tbody>
            </table>

            <div class="d-none tsc-template">
                <div class="m-1">
                    <select class="form-control form-control-sm" id="teacher"
                        title="Simple select"
                        data-text="{{ Translator::phrase("add_new_option") }}"
                        data-placeholder="{{ Translator::phrase("choose.teacher") }}" name="teacher[]"
                        data-select-value="{{config("pages.form.data.teacher")}}"
                        {{(array_key_exists("teacher",config("pages.form.validate.rules"))) ? "required" : ""}}>
                        @foreach($teacher["data"] as $o)
                        <option data-src="{{$o["photo"]}}" value="{{$o["id"]}}">
                            {{ $o["first_name"]}} {{ $o["last_name"]}}</option>
                        @endforeach

                    </select>
                </div>

                <div class="m-1">
                    <select class="form-control form-control-sm" id="study_subject"
                        title="Simple select"

                        data-text="{{ Translator::phrase("add_new_option") }}"
                        data-placeholder="{{ Translator::phrase("choose.study_subject") }}"
                        name="study_subject[]"
                        data-select-value="{{config("pages.form.data.study_subject")}}"
                        {{(array_key_exists("study_subject",config("pages.form.validate.rules"))) ? "required" : ""}}>
                        @foreach($study_subject["data"] as $o)
                        <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                        @endforeach

                    </select>
                </div>
                <div class="m-1">
                    <select class="form-control form-control-sm" id="study_class"
                        title="Simple select"
                        data-placeholder="{{ Translator::phrase("choose.study_class") }}"
                        name="study_class[]" data-select-value=""
                        {{(array_key_exists("study_class",config("pages.form.validate.rules"))) ? "required" : ""}}>
                        @foreach($study_class["data"] as $o)
                        <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option> @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
