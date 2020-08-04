<style>
    .custom-checkbox .custom-control-input~.custom-control-label,
    .custom-radio .custom-control-input~.custom-control-label {
        padding-left: 1.75rem;
    }
</style>
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            @if ($quiz)
            @php $response = $quiz; @endphp
            @include("QuizStudentAnswer.includes.list.includes.b",$response)
            @include("QuizStudentAnswer.includes.list.includes.c",$response)
            @endif
        </div>
    </div>
    <div class="col-xl-4">
        @if (Internet::conneted())
        <div class="card d-none" data-toggle="weather">
            <div class="card-header">
                <div class="city-title ">
                    <span id="location"> </span>
                </div>
            </div>
            <div class="card-body">
                <div class="city-weather-temperature loader">
                    <span class="celsius fahrenheit-btn "></span>
                    <span class="fahrenheit celsius-btn"></span>
                </div>
                <div class="city-weather-description">
                    <span id="icon"></span><br>
                    <span id="description"></span>
                </div>
            </div>
            <div class="card-footer">
                <div class="nav-info clearfix">
                    <div class="add-info">
                        <ul id="details">
                            <li>
                                <span id="todayC"> </span>
                                <span id="todayF"> </span>
                            </li>
                            <li>
                                <span id="tomorrowC"> </span>
                                <span id="tomorrowF"> </span>
                            </li>
                            <li>
                                <span id="afterTomorrowC"> </span>
                                <span id="afterTomorrowF"> </span>
                            </li>
                            <li>
                                <span id="afterAfterTomorrowC"> </span>
                                <span id="afterAfterTomorrowF"> </span>
                            </li>
                        </ul>
                    </div> <!-- add-info -->
                </div> <!-- nav-info -->

            </div>
        </div>
        @endif

        <div class="card widget-calendar">
            <div class="card-header">
                <div class="h5 text-muted mb-1 widget-calendar-today btn btn-sm"></div>
                <div class="d-flex">
                    <a href="#" class="text-white widget-calendar-btn-prev btn-sm bg-{{config("app.theme_color.name")}}"
                        data-theme-bg-color="{{config("app.theme_color.name")}}">
                        <i class="fas fa-angle-left"></i>
                    </a>
                    <div class="h3 mb-0 widget-calendar-month m-auto"></div>
                    <a href="#" class="text-white widget-calendar-btn-next btn-sm bg-{{config("app.theme_color.name")}}"
                        data-theme-bg-color="{{config("app.theme_color.name")}}">
                        <i class="fas fa-angle-right"></i>
                    </a>

                </div>

            </div>
            <div class="card-body">
                <div data-toggle="widget-calendar" data-event-url="{{URL::to("/holiday/calendar")}}"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-12">
        @if ($study_course_session && $study_course_session["success"])
        @foreach ($study_course_session["data"] as $course_session)
        <div class="card">
            <div class="card-header">
                <div class="d-block text-center">
                    <span class="font-weight-bold text-lg">
                        {{$course_session["name"]}}
                    </span>
                    <br>
                    <span>
                        {{$course_session["study_start"]}} &#9866; {{$course_session["study_end"]}}
                    </span>
                </div>
            </div>

            <div class="card-body">

                @if ($course_session["schedules"])
                @foreach ($course_session["schedules"] as $schedule)

                <div class="card">
                    @include(config("pages.parent").".includes.study.includes.schedule.includes.body",$schedule)
                </div>
                @endforeach
                @endif

                @if ($course_session["attendances"])

                <div class="card">
                    @php
                    $response = $course_session["attendances"];
                    $holiday = $course_session["holiday"];
                    $no_name = true;
                    @endphp
                    @include(config("pages.parent").".includes.study.includes.attendance.includes.body",[$response,$holiday,$no_name])
                </div>
                @endif



                @if ($course_session["score"])
                <div class="card">
                    @php
                    $response = $course_session["score"];
                    $no_name = true;
                    @endphp
                    @include(config("pages.parent").".includes.study.includes.score.includes.body",[$response,$no_name])
                </div>
                @endif


            </div>
        </div>

        @endforeach
        @endif
    </div>

</div>
