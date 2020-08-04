<div class="card-body p-0">
    <div class="table-responsive" data-toggle="list" data-list-values='["id", "quiz","student"]'>
        <table id="quiz-table" class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th width="1" class="sort" data-sort="id">{{Translator::phrase("numbering")}}​</th>
                    <th width="1" class="sort" data-sort="quiz">{{Translator::phrase("quiz")}}​</th>
                    <th class="sort">
                        @if (request()->segment(3) !== "quiz")
                        <a href="{{str_replace("answer/add","list",config("pages.form.action.detect"))}}"
                            target="_blank" class="float-right full-link">
                            <i class="fas fa-external-link"></i>
                        </a>
                        @endif
                    </th>

                </tr>
            </thead>
            <tbody class="list">
                @if ($response['success'])
                @foreach ($response['data'] as $row)
                <tr data-id="{{$row["id"]}}">
                    <td class="id">{{$row["id"]}}</td>
                    <td class="quiz">
                        <button class="btn btn-sm collapsed" data-toggle="collapse" data-target="#collapse-{{$row["id"]}}">
                            <i class="fas fa-plus-minus"></i>
                        </button>
                        <img data-src="{{ $row['image']}}" alt="" width="50px" height="50px">
                        {{$row["name"]}}
                    </td>
                    <td>
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
                                <tbody class="collapse" id="collapse-{{$row["id"]}}">
                                    @foreach ($row["children"] as $q)
                                    <tr>
                                        <td>{{ $q['id']}}</td>
                                        <td>{{ $q['quiz_type']['name']}}</td>
                                        <td>
                                            <div>
                                                <span class="text-red">{{Translator::phrase("question. :")}}​</span>
                                                <span class="ml-2 text-pre-wrap text-break">{{ $q['question']}} </span>
                                            </div>
                                            <hr class="my-2">
                                            <div>
                                                @if ($q['answered'])
                                                @if (!is_null($q['answered']['marks']))
                                                <div class="d-flex mb-3">
                                                    <span
                                                        class="text-yellow">{{Translator::phrase("answer. :")}}​</span>
                                                    <span class="ml-2 w-100">
                                                        @if ($q["quiz_answer_type"]["id"] == 1)

                                                        @foreach ($q["answer"] as $answer)
                                                        <div class="custom-control custom-radio mx-2">
                                                            <input disabled
                                                                {{$answer["correct_answer"] ? "checked" : ""}}
                                                                type="radio"
                                                                class="custom-control-input position-absolute">
                                                            <label
                                                                class="custom-control-label">{{$answer["answer"]}}</label>
                                                        </div>
                                                        @endforeach
                                                        @elseif ($q["quiz_answer_type"]["id"] == 2)

                                                        <div data-toggle="checkbox-limit1"
                                                            data-limit="{{$q["answer_limit"]}}">
                                                            <div>
                                                                {{Translator::phrase("this_question_can_answer. ". $q["answer_limit"]." .answer")}}
                                                            </div>
                                                            @foreach ($q["answer"] as $answer)
                                                            <div class="custom-control custom-checkbox">
                                                                <input disabled
                                                                    {{$answer["correct_answer"] ? "checked" : ""}}
                                                                    type="checkbox" value="{{$answer["id"]}}"
                                                                    name="answer[]"
                                                                    class="custom-control-input position-absolute">
                                                                <label
                                                                    class="custom-control-label">{{$answer["answer"]}}</label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        @elseif ($q["quiz_answer_type"]["id"] == 3)
                                                        <span
                                                            class="ml-2 text-pre-wrap text-break">{{ $q['answer'][0]['answer']}}
                                                        </span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="d-flex mb-3">
                                                    <span
                                                        class="text-green">{{Translator::phrase("answered. :")}}​</span>
                                                    @if ($q["quiz_answer_type"]["id"] == 1)
                                                    @foreach ($q["answer"] as $answer)
                                                    <div class="custom-control custom-radio mx-2">
                                                        <input disabled
                                                            {{in_array($answer["id"],explode(",",$q['answered']['answered'])) ? "checked"  : "" }}
                                                            type="radio" class="custom-control-input position-absolute">
                                                        <label
                                                            class="custom-control-label">{{$answer["answer"]}}</label>
                                                    </div>
                                                    @endforeach
                                                    @elseif ($q["quiz_answer_type"]["id"] == 2)
                                                    <div data-toggle="checkbox-limit1"
                                                        data-limit="{{$q["answer_limit"]}}">
                                                        <div>
                                                            {{Translator::phrase("this_question_can_answer. ". $q["answer_limit"]." .answer")}}
                                                        </div>
                                                        @foreach ($q["answer"] as $answer)
                                                        <div class="custom-control custom-checkbox">
                                                            <input disabled
                                                                {{in_array($answer["id"],explode(",",$q['answered']['answered'])) ? "checked"  : "" }}
                                                                type="checkbox" value="{{$answer["id"]}}"
                                                                name="answer[]"
                                                                class="custom-control-input position-absolute">
                                                            <label
                                                                class="custom-control-label">{{$answer["answer"]}}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @elseif ($q["quiz_answer_type"]["id"] == 3)
                                                    <span
                                                        class="form-control text-pre-wrap text-break">{{$q['answered']['answered']}}</span>
                                                    @endif


                                                </div>
                                                <div class="d-flex mb-3">
                                                    <span class="text-blue">{{Translator::phrase("marksed. :")}}​</span>
                                                    <span class="ml-2">{{$q['answered']['marks']}}</span>
                                                </div>

                                                @else
                                                <form role="update" class="needs-validation" novalidate="" method="POST"
                                                    action="{{str_replace("add","update",config("pages.form.action.detect"))}}"
                                                    id="form-quiz-answer" enctype="multipart/form-data"
                                                    data-validation="{{json_encode(config("pages.form.validate"))}}">
                                                    <div class="d-flex mb-3">
                                                        <span
                                                            class="text-green">{{Translator::phrase("answered. :")}}​</span>
                                                        <span class="ml-2 w-100">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{$q['answered']['id']}}">
                                                            <input type="hidden" name="quiz_student"
                                                                value="{{$row['quiz_student']}}">
                                                            <input type="hidden" name="quiz_question"
                                                                value="{{ $q['id']}}">

                                                            @if ($q["quiz_answer_type"]["id"] == 1)

                                                            @foreach ($q["answer"] as $answer)
                                                            <div class="custom-control custom-radio">
                                                                <input disabled
                                                                    {{in_array($answer["id"],explode(",",$q['answered']['answered'])) ? "checked"  : "" }}
                                                                    type="radio" id="answer-{{$answer["id"]}}"
                                                                    value="{{$answer["id"]}}" name="answer[]"
                                                                    class="custom-control-input position-absolute">
                                                                <label class="custom-control-label"
                                                                    for="answer-{{$answer["id"]}}">{{$answer["answer"]}}</label>
                                                            </div>
                                                            @endforeach

                                                            @elseif ($q["quiz_answer_type"]["id"] == 2)
                                                            <div data-toggle="checkbox-limit"
                                                                data-limit="{{$q["answer_limit"]}}">
                                                                <div>
                                                                    {{Translator::phrase("this_question_can_answer. ". $q["answer_limit"]." .answer")}}
                                                                </div>
                                                                @foreach ($q["answer"] as $answer)
                                                                <div class="custom-control custom-checkbox">
                                                                    <input disabled
                                                                        {{in_array($answer["id"],explode(",",$q['answered']['answered'])) ? "checked"  : "" }}
                                                                        type="checkbox" id="answer-{{$answer["id"]}}"
                                                                        value="{{$answer["id"]}}" name="answer[]"
                                                                        class="custom-control-input position-absolute">
                                                                    <label class="custom-control-label"
                                                                        for="answer-{{$answer["id"]}}">{{$answer["answer"]}}</label>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                            @elseif ($q["quiz_answer_type"]["id"] == 3)
                                                            <textarea disabled
                                                                class="form-control text-pre-wrap text-break"
                                                                name="answer[]"
                                                                id="answer">{{$q['answered']['answered']}}</textarea>
                                                            @endif


                                                        </span>
                                                    </div>
                                                    <div class="float-right">
                                                        <button class="btn btn-danger btn-sm d-none" id="cancel"
                                                            type="button">
                                                            <i class="fas fa-times-circle"></i>
                                                            {{Translator::phrase("cancel")}}
                                                        </button>
                                                        <button class="btn btn-primary btn-sm" id="edit" type="button">
                                                            <i class="fas fa-edit"></i>
                                                            {{Translator::phrase("edit")}}
                                                        </button>
                                                        <button class="btn btn-primary btn-sm d-none"
                                                            type="submit">{{Translator::phrase("update")}}</button>
                                                    </div>
                                                </form>
                                                @endif

                                                @else

                                                <form role="{{config("pages.form.role")}}" class="needs-validation"
                                                    novalidate="" method="POST"
                                                    action="{{config("pages.form.action.detect")}}"
                                                    id="form-quiz-answer" enctype="multipart/form-data"
                                                    data-validation="{{json_encode(config("pages.form.validate"))}}">
                                                    <div class="d-flex mb-3">
                                                        <span data-update-text="{{Translator::phrase("answered. :")}}"
                                                            id="answer-label"
                                                            class="text-green">{{Translator::phrase("answer. :")}}​</span>
                                                        <span class="ml-2 w-100">
                                                            @csrf
                                                            <input type="hidden" name="id" value="">
                                                            <input type="hidden" name="quiz_student"
                                                                value="{{$row['quiz_student']}}">
                                                            <input type="hidden" name="quiz_question"
                                                                value="{{ $q['id']}}">

                                                            @if ($q["quiz_answer_type"]["id"] == 1)

                                                            @foreach ($q["answer"] as $answer)
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="answer-{{$answer["id"]}}"
                                                                    value="{{$answer["id"]}}" name="answer[]"
                                                                    class="custom-control-input position-absolute">
                                                                <label class="custom-control-label"
                                                                    for="answer-{{$answer["id"]}}">{{$answer["answer"]}}</label>
                                                            </div>
                                                            @endforeach

                                                            @elseif ($q["quiz_answer_type"]["id"] == 2)
                                                            <div data-toggle="checkbox-limit"
                                                                data-limit="{{$q["answer_limit"]}}">
                                                                <div>
                                                                    {{Translator::phrase("this_question_can_answer. ". $q["answer_limit"]." .answer")}}
                                                                </div>
                                                                @foreach ($q["answer"] as $answer)
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" id="answer-{{$answer["id"]}}"
                                                                        value="{{$answer["id"]}}" name="answer[]"
                                                                        class="custom-control-input position-absolute">
                                                                    <label class="custom-control-label"
                                                                        for="answer-{{$answer["id"]}}">{{$answer["answer"]}}</label>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                            @elseif ($q["quiz_answer_type"]["id"] == 3)
                                                            <textarea class="form-control text-pre-wrap text-break"
                                                                name="answer[]" id="answer"></textarea>
                                                            @endif

                                                        </span>
                                                    </div>
                                                    <div class="float-right">
                                                        <button class="btn btn-danger btn-sm d-none" id="cancel"
                                                            type="button">
                                                            <i class="fas fa-times-circle"></i>
                                                            {{Translator::phrase("cancel")}}
                                                        </button>
                                                        <button class="btn btn-primary btn-sm d-none" id="edit"
                                                            type="button">
                                                            <i class="fas fa-edit"></i>
                                                            {{Translator::phrase("edit")}}
                                                        </button>
                                                        <button class="btn btn-primary btn-sm"
                                                            data-update-text="{{Translator::phrase("update")}}"
                                                            type="submit">{{Translator::phrase("ok")}}</button>
                                                    </div>
                                                </form>
                                                @endif

                                            </div>
                                        </td>
                                        <td>
                                            <span> {{ $q['marks']}} </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="3" class="text-center p-3">
                        <p class="m-0"><svg width="64" height="41" viewBox="0 0 64 41"
                                xmlns="http://www.w3.org/2000/svg">
                                <g transform="translate(0 1)" fill="none" fill-rule="evenodd">
                                    <ellipse fill="#F5F5F5" cx="32" cy="33" rx="32" ry="7"></ellipse>
                                    <g fill-rule="nonzero" stroke="#D9D9D9">
                                        <path
                                            d="M55 12.76L44.854 1.258C44.367.474 43.656 0 42.907 0H21.093c-.749 0-1.46.474-1.947 1.257L9 12.761V22h46v-9.24z">
                                        </path>
                                        <path
                                            d="M41.613 15.931c0-1.605.994-2.93 2.227-2.931H55v18.137C55 33.26 53.68 35 52.05 35h-40.1C10.32 35 9 33.259 9 31.137V13h11.16c1.233 0 2.227 1.323 2.227 2.928v.022c0 1.605 1.005 2.901 2.237 2.901h14.752c1.232 0 2.237-1.308 2.237-2.913v-.007z"
                                            fill="#FAFAFA"></path>
                                    </g>
                                </g>
                            </svg></p>
                        <span>{{ $response["message"] }}</span>
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>
</div>
