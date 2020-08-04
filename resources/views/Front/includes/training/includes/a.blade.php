@if ($study_course["success"])
<ul class="list-group list-group-flush list my--3">
    @foreach ($study_course["data"] as $course)

    <li class="list-group-item px-0">
        <div class="row align-items-center">
            <div class="col-auto">
                <a href="#">
                    <img class="img-thumbnail" width="100" alt="Image placeholder" src="{{$course["image"]}}">
                </a>
            </div>
            <div class="col ml--2">
                <h4 class="mb-0">
                    <a href="#!" class="">{{$course["name"]}}</a>
                </h4>
            </div>
            <div class="col-auto">
                @auth
                    @if (Auth::user()->role_id == 6)
                        <a href="{{url(Auth::user()->role()."/study/course/add?programId=".$course["study_program"]["id"]."&courseId=".$course["id"])}}"
                            class="btn btn-sm btn-primary font-weight-300">
                            {{Translator::phrase("apply_now")}}
                        </a>
                    @endif

                @else
                    <a href="{{url("login")}}"
                        class="btn btn-sm btn-primary font-weight-300">
                        {{Translator::phrase("apply_now")}}
                    </a>
                @endauth

            </div>
        </div>


    </li>
    @endforeach

</ul>
@else
<div class="text-center text-red" style="height:400px">
    {{$study_course["message"]}}
</div>
@endif
