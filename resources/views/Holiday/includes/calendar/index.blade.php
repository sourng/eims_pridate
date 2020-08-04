<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-calendar">
            <div class="card-header">
                <div class="d-flex">
                    <a href="#" class="text-white fullcalendar-btn-prev btn bg-{{config("app.theme_color.name")}}">
                        <i class="fas fa-angle-left"></i>
                    </a>
                    <div class="fullcalendar-title h2 mb-0 m-auto"> </div>
                    <a href="#" class="text-white fullcalendar-btn-next btn bg-{{config("app.theme_color.name")}}">
                        <i class="fas fa-angle-right"></i>
                    </a>
                    <a href="#" class="btn border btn-secondary active" data-calendar-view="month">
                        <i class="fas fa-th"></i>
                    </a>
                    <a href="#" class="btn border btn-secondary" data-calendar-view="listMonth">
                        <i class="fas fa-th-list"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="calendar" data-toggle="calendar" id="calendar"
                    data-event-url="{{URL::to("/holiday/calendar")}}" data-alldaytext="{{Translator::phrase("all_day")}}"></div>
            </div>
        </div>
    </div>
</div>
