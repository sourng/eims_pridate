@foreach ($response["data"] as $row)
<tr class="list">
    <td>
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" data-toggle="table-checked" id="table-check-{{$row["id"]}}"
                data-checked-show-controls='["edit","delete"]' type="checkbox" data-checked="table-checked"
                value="{{$row["id"]}}">
            <label class="pl-4 custom-control-label" for="table-check-{{$row["id"]}}"></label>
        </div>
    </td>
    <td class="text-center id">{{ $row["node"]["id"]}}</td>
    <td class="text-left px-2 name"> {{ $row["node"]["name"]}}</td>
    <td class="text-center gender">{{mb_substr($row["node"]["node"]["gender"]["name"], 0, 1,'utf-8')}}</td>

    @foreach ($row['scores'] as $key => $scores)
    @if($key != "attendance_marks" && $key != "other_marks")
    <td class="text-center {{$scores["pass_or_fail"] == "fail" ? "bg-gray text-white" :"" }}">
        <span>{{$scores["marks"]}}</span>
    </td>
    @endif
    @endforeach
</tr>
@endforeach
