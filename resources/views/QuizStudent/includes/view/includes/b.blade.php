<div class="card-body">
    <div class="table-responsive">
        <table class="table border">
            <thead>
                <tr>
                    <th width="1">{{Translator::phrase("numbering")}}​</th>
                    <th width="1">{{Translator::phrase("quiz_type")}}​</th>
                    <th>{{Translator::phrase("question. & .answered")}}​</th>
                    <th width="1">{{Translator::phrase("marks")}}​</th>
                </tr>
            </thead>
            <tbody>
                @foreach (config("pages.form.data.quiz_answered") as $q)
                <tr>
                    <td>{{ $q['question']['id']}}</td>
                    <td>{{ $q['question']['quiz_type']['name']}}</td>
                    <td>
                        <div>
                            <span class="text-red">{{Translator::phrase("question. :")}}​</span>
                            <span class="ml-2 text-pre-wrap text-break">{{ $q['question']['question']}}
                            </span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex mb-3">
                            <span class="text-yellow">{{Translator::phrase("answer. :")}}​</span>

                            @if ($q['question']["quiz_answer_type"]["id"] == 1)
                            @foreach ($q["question"]["answer"] as $answer)
                            <div class="custom-control custom-radio mx-2">
                                <input disabled {{$answer["correct_answer"] ? "checked" : ""}} type="radio"
                                    class="custom-control-input position-absolute">
                                <label class="custom-control-label">{{$answer["answer"]}}</label>
                            </div>

                            @endforeach
                            @elseif ($q['question']["quiz_answer_type"]["id"] == 2)
                            <div data-toggle="checkbox-limit1" data-limit="{{$q["question"]["answer_limit"]}}">
                                <div>
                                    {{Translator::phrase("this_question_can_answer. ". $q["question"]["answer_limit"]." .answer")}}
                                </div>
                                @foreach ($q["question"]["answer"] as $answer)
                                <div class="custom-control custom-checkbox">
                                    <input disabled {{$answer["correct_answer"] ? "checked" : ""}} type="checkbox"
                                        value="{{$answer["id"]}}" name="answer[]"
                                        class="custom-control-input position-absolute">
                                    <label class="custom-control-label">{{$answer["answer"]}}</label>
                                </div>
                                @endforeach
                            </div>
                            @elseif ($q['question']["quiz_answer_type"]["id"] == 3)
                            <span class="ml-2 text-pre-wrap text-break">{{ $q['question']['answer'][0]['answer']}}
                            </span>
                            @endif

                        </div>
                        <div class="d-flex mb-3">
                            <span class="text-green">{{Translator::phrase("answered. :")}}​</span>

                            @if ($q['question']["quiz_answer_type"]["id"] == 1)
                            @foreach ($q["question"]["answer"] as $answer)
                            <div class="custom-control custom-radio mx-2">
                                <input disabled
                                    {{in_array($answer["id"],explode(",",$q['answered'])) ? "checked"  : "" }}
                                    type="radio" class="custom-control-input position-absolute">
                                <label class="custom-control-label">{{$answer["answer"]}}</label>
                            </div>
                            @endforeach
                            @elseif ($q['question']["quiz_answer_type"]["id"] == 2)
                            <div data-toggle="checkbox-limit1" data-limit="{{$q["question"]["answer_limit"]}}">
                                <div>
                                    {{Translator::phrase("this_question_can_answer. ". $q["question"]["answer_limit"]." .answer")}}
                                </div>
                                @foreach ($q["question"]["answer"] as $answer)
                                <div class="custom-control custom-checkbox">
                                    <input disabled
                                        {{in_array($answer["id"],explode(",",$q['answered'])) ? "checked"  : "" }}
                                        type="checkbox" value="{{$answer["id"]}}" name="answer[]"
                                        class="custom-control-input position-absolute">
                                    <label class="custom-control-label">{{$answer["answer"]}}</label>
                                </div>
                                @endforeach
                            </div>
                            @elseif ($q['question']["quiz_answer_type"]["id"] == 3)
                            <span class="form-control text-pre-wrap text-break">{{$q['answered']}}</span>
                            @endif

                        </div>
                        <form role="update" class="needs-validation" novalidate="" method="POST"
                            action="{{str_replace("add","marks/update",config("pages.form.action.detect"))}}"
                            id="form-quiz-answer" enctype="multipart/form-data"
                            data-validation="{{json_encode(config("pages.form2.validate"))}}">
                            <div class="d-flex mb-3">
                                @csrf
                                <input type="hidden" name="id" value="{{$q['id']}}">
                                <span class="text-blue">{{Translator::phrase("marksed. :")}}​</span>
                                <div class="form-row">
                                    <div class="col">
                                        <span class="form-control form-control-sm ml-2"
                                            max="{{ $q['question']['marks']}} " type="number" name="marks"
                                            id="marks">{{$q['marks'] ? $q['marks'] :$q['correct_marks']}}</span>
                                    </div>
                                    <div class="col">
                                        <div class="ml-1">
                                            <button class="btn btn-danger btn-sm d-none" id="cancel" type="button"
                                                data-attr-remove="style" data-control="marks" data-change-tag="span">
                                                <i class="fas fa-times-circle"></i>
                                                {{Translator::phrase("cancel")}}
                                            </button>
                                            <button class="btn btn-primary btn-sm" id="edit" type="button"
                                                data-attr-remove="style" data-control="marks" data-change-tag="input">
                                                <i class="fas fa-edit"></i>
                                                {{Translator::phrase("edit")}}
                                            </button>
                                            <button class="btn btn-primary btn-sm d-none"
                                                type="submit">{{Translator::phrase("update")}}</button>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </form>
                        @php
                        $validate = [
                        'rules' => [],
                        'attributes' => [],
                        'messages' => [],
                        'questions' => [],
                        ];
                        @endphp
                        <form action="{{str_replace("add","answer_again",config("pages.form.action.detect"))}}"
                            method="POST" id="form-quiz-answer" data-validate='{{json_encode($validate)}}'>
                            @csrf
                            <input type="hidden" name="id" value="{{$q['id']}}">
                            <button class="btn btn-info btn-sm"
                                type="submit">{{Translator::phrase("answer_again")}}</button>
                        </form>

                    </td>
                    <td>
                        <span> {{ $q['question']['marks']}} </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
