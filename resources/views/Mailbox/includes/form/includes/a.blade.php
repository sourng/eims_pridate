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
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label d-none" for="recipient">
                            {{ Translator:: phrase('recipient') }}

                            @if(config("pages.form.validate.rules.recipient")) <span
                                class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>
                        <select class="form-control" data-toggle="taginputs" id="recipient"
                            title="Simple select" 
                            data-text="{{ Translator::phrase("add_new_option") }}"

                            data-allow-clear="true" data-placeholder="{{Translator::phrase("recipient") }}"
                            name="recipient[]"
                            data-name="recipient[]"
                            data-select-value="{{config("pages.form.data.place_of_birth.province.id")}}"
                            {{config("pages.form.validate.rules.recipient") ? "required" : ""}}>
                            @foreach($recipient["data"] as $o)
                            <option data-src="{{$o["profile"]}}" value="{{$o["id"]}}">
                                {{ $o["name"]}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label d-none" for="subject">
                            {{ Translator:: phrase("subject") }}

                            @if(config("pages.form.validate.rules.subject"))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>
                        <input type="text" class="form-control" name="subject" id="subject"
                            placeholder="{{ Translator::phrase("subject") }}"
                            value="{{config("pages.form.data.subject")}}"
                            {{config("pages.form.validate.rules.subject") ? "required" : ""}} />

                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label d-none" for="message">
                            {{ Translator:: phrase('message') }}

                            @if(config("pages.form.validate.rules.message")) <span
                                class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>
                        <div>
                            <div data-name="message" id="message"
                                data-placeholder="{{ Translator::phrase("message") }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
