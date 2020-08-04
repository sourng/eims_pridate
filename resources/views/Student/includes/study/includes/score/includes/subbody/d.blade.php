@if (array_key_exists($key,$response["study_subject"]))
<td class="text-center {{$scores["study_subject"]["name"]}} {{$scores["pass_or_fail"] == "fail" ? "bg-gray text-white" :"" }}"
    data-url="{{$scores["action"]}}"
     data-id="{{$row["id"]}}" data-subject-id="{{$scores["study_subject"]["id"]}}">
    <span>{{$scores["marks"]}}</span>
</td>
@else
<td class="text-center {{$key}}"  data-url="{{$scores["action"]}}"
     data-id="{{$row["id"]}}" data-key="{{$key}}">
    <span>{{$scores["marks"]}}</span>

</td>
@endif
