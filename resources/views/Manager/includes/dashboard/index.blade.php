<div class="row bg-{{config("app.theme_color.name")}} rounded" data-theme-bg-color="{{config("app.theme_color.name")}}">
    <div class="col-xl-8">
        <div class="row">
            <div class="col-xl-6">
                @include(Auth::user()->role('view_path').".includes.dashboard.includes.staff.index")
            </div>
            <div class="col-xl-6">
                @include(Auth::user()->role('view_path').".includes.dashboard.includes.student.index")
            </div>
        </div>

        <div class="row">
            @include(Auth::user()->role('view_path').".includes.dashboard.includes.studyProgram.index")
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
        @include(Auth::user()->role('view_path').".includes.dashboard.includes.user.index")
    </div>

</div>
