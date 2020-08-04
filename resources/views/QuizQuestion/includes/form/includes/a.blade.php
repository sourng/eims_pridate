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
                    <div class="col-md-4 mb-3">
                        <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                            title="{{config("pages.form.validate.questions.quiz")}}" class="form-control-label"
                            for="quiz">

                            {{ Translator:: phrase("quiz") }}

                            @if(config("pages.form.validate.rules.quiz"))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset">
                                <i class="fas fa-asterisk fa-xs"></i>
                            </span>
                            @endif
                        </label>

                        <select class="form-control" data-toggle="select" id="quiz" title="Simple select"


                            data-text="{{ Translator::phrase("add_new_option") }}"
                            data-placeholder="{{ Translator::phrase("choose.quiz") }}" name="quiz"
                            data-select-value="{{ request("quizId", config("pages.form.data.quiz.id"))}}"
                            {{config("pages.form.validate.rules.quiz") ? "required" : ""}}>
                            @foreach($quiz["data"] as $o)
                            <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                            title="{{config("pages.form.validate.questions.quiz_answer_type")}}"
                            class="form-control-label" for="quiz_answer_type">

                            {{ Translator:: phrase("quiz_answer_type") }}

                            @if(config("pages.form.validate.rules.quiz_answer_type"))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset">
                                <i class="fas fa-asterisk fa-xs"></i>
                            </span>
                            @endif
                        </label>

                        <select class="form-control" data-toggle="select" id="quiz_answer_type" title="Simple select"


                            data-text="{{ Translator::phrase("add_new_option") }}"
                            data-placeholder="{{ Translator::phrase("choose.quiz_answer_type") }}"
                            name="quiz_answer_type"
                            data-select-value="{{config("pages.form.data.quiz_answer_type.id")}}"
                            {{config("pages.form.validate.rules.quiz_answer_type") ? "required" : ""}}>
                            @foreach($quiz_answer_type["data"] as $o)
                            <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                            title="{{config("pages.form.validate.questions.quiz_type")}}" class="form-control-label"
                            for="quiz_type">

                            {{ Translator:: phrase("quiz_type") }}

                            @if(config("pages.form.validate.rules.quiz_type"))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset">
                                <i class="fas fa-asterisk fa-xs"></i>
                            </span>
                            @endif
                        </label>

                        <select class="form-control" data-toggle="select" id="quiz_type" title="Simple select"
                            

                            data-text="{{ Translator::phrase("add_new_option") }}"
                            data-placeholder="{{ Translator::phrase("choose.quiz_type") }}" name="quiz_type"
                            data-select-value="{{config("pages.form.data.quiz_type.id")}}"
                            {{config("pages.form.validate.rules.quiz_type") ? "required" : ""}}>
                            @foreach($quiz_type["data"] as $o)
                            <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>



                <div class="mb-3 p-3 border rounded">
                    <div class="form-row">
                        <div class="col-md-10 mb-3">
                            <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                                title="{{config("pages.form.validate.question")}}" class="form-control-label"
                                for="question">

                                {{ Translator:: phrase("question") }}

                                @if(config("pages.form.validate.rules.question"))
                                <span class="badge badge-md badge-circle badge-floating badge-danger"
                                    style="background:unset">
                                    <i class="fas fa-asterisk fa-xs"></i>
                                </span>
                                @endif
                            </label>
                            <textarea class="form-control" title="{{ Translator::phrase("question") }}"
                                placeholder="{{ Translator::phrase("question") }}" id="question" name="question"
                                {{config("pages.form.validate.rules.question") ? "required" : ""}}>{{config("pages.form.data.question")}}</textarea>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                                title="{{config("pages.form.validate.marks")}}" class="form-control-label" for="marks">

                                {{ Translator:: phrase("marks") }}

                                @if(config("pages.form.validate.rules.marks"))
                                <span class="badge badge-md badge-circle badge-floating badge-danger"
                                    style="background:unset">
                                    <i class="fas fa-asterisk fa-xs"></i>
                                </span>
                                @endif
                            </label>

                            <input type="text" class="form-control" name="marks" id="marks"
                                placeholder="{{ Translator::phrase("marks") }}"
                                value="{{config("pages.form.data.marks")}}"
                                {{config("pages.form.validate.rules.marks") ? "required" : ""}} />

                        </div>
                    </div>
                    <div id="taget_quiz_question">
                        @if (config("pages.form.data.answer"))
                        @foreach (config("pages.form.data.answer") as $answer)
                        <div class="form-row" data-clone="_quiz_question">

                            <div class="col-md-2">
                                <div class="custom-control custom-checkbox">
                                    <input {{$answer["correct_answer"] ? "checked" : ""}} type="checkbox"
                                        data-fixed="{{$answer["id"]}}" id="correct_answer-[{{$answer["id"]}}]" value="1"
                                        name="correct_answer[id-{{$answer["id"]}}]"
                                        class="custom-control-input position-absolute">
                                    <label class="custom-control-label"
                                        for="correct_answer-[{{$answer["id"]}}]">{{ Translator::phrase("correct_answer") }}</label>
                                </div>
                            </div>
                            <div class="col-md-8 mb-3">
                                <textarea class="form-control" title="{{ Translator::phrase("answer") }}"
                                    placeholder="{{ Translator::phrase("answer") }}" id="answer"
                                    name="answer[id-{{$answer["id"]}}]"
                                    {{config("pages.form.validate.rules.answer") ? "required" : ""}}>{{$answer["answer"]}}</textarea>
                            </div>
                            <div class="col-md-2  mb-3">
                                <a href="#" data-name="answer[]" data-target-change="#answer" data-toggle="clone"
                                    data-clone-from="_quiz_question" data-clone-target="taget_quiz_question"
                                    class="btn btn-sm btn-default"><i class="fas fa-plus"></i></a>
                                <a href="#" data-clone-delete="_quiz_question" class="btn btn-sm btn-danger"><i
                                        class="fas fa-trash"></i></a>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="form-row" data-clone="_quiz_question">
                            <div class="col-md-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="correct_answer-0" value="1" name="correct_answer[]"
                                        class="custom-control-input position-absolute">
                                    <label class="custom-control-label"
                                        for="correct_answer-0">{{ Translator::phrase("correct_answer") }}</label>
                                </div>
                            </div>
                            <div class="col-md-8 mb-3">
                                <textarea class="form-control" title="{{ Translator::phrase("answer") }}"
                                    placeholder="{{ Translator::phrase("answer") }}" id="answer" name="answer[]"
                                    {{config("pages.form.validate.rules.answer") ? "required" : ""}}></textarea>
                            </div>
                            <div class="col-md-2  mb-3">
                                <a href="#" data-toggle="clone" data-clone-from="_quiz_question"
                                    data-clone-target="taget_quiz_question" class="btn btn-sm btn-default"><i
                                        class="fas fa-plus"></i></a>
                                <a href="#" data-clone-delete="_quiz_question"
                                    class="btn btn-sm btn-danger invisible"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
