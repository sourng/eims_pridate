<div class="card m-0">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            A
        </label>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-row">
                    @csrf
                    @if (request()->segment(3) == "view")
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="id">
                            {{ Translator:: phrase("numbering") }}
                        </label>
                        <span class="form-control" id="id" name="id"
                            value="{{config("pages.form.data.id")}}">{{config("pages.form.data.id")}}</span>
                    </div>
                    @endif
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="staff">
                            {{ Translator:: phrase("staff") }}

                            @if(array_key_exists("staff",config("pages.form.validate.rules")))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>

                        <select class="form-control" data-toggle="select" id="staff" title="Simple select"
                            data-text="{{ Translator::phrase("add_new_option") }}"
                            data-placeholder="{{ Translator::phrase("choose.staff") }}" name="staff"
                            data-select-value="{{config("pages.form.data.staff.id")}}">
                            @foreach($staff["data"] as $o)
                            <option data-src="{{$o["photo"]}}" value="{{$o["id"]}}">
                                {{ $o["name"]}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="study_subject">
                            {{ Translator:: phrase("study_subject") }}

                            @if(array_key_exists("study_subject",config("pages.form.validate.rules")))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>

                        <select class="form-control" data-toggle="select" id="study_subject" title="Simple select"
                            data-text="{{ Translator::phrase("add_new_option") }}"
                            data-placeholder="{{ Translator::phrase("choose.study_subject") }}" name="study_subject"
                            data-select-value="{{config("pages.form.data.study_subject.id")}}">
                            @foreach($study_subject["data"] as $o)
                            <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label class="form-control-label" for="name">
                            {{ Translator:: phrase("year") }}

                            @if(config("pages.form.validate.rules.year"))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>
                        <input type="year" class="form-control" name="year" id="year"
                            placeholder="{{ Translator::phrase("year") }}" value="{{config("pages.form.data.year")}}"
                            {{config("pages.form.validate.rules.year") ? "required" : ""}} />

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
