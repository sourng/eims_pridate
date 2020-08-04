@foreach ($response["data"] as $row)
<tr data-id="{{$row["id"]}}" class="{{$row["grade"] == null ? "strikeout": ""}}">
    @if (config("pages.parameters.param1") != "report")
    <td>
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" data-toggle="table-checked" id="table-check-{{$row["id"]}}"
                data-checked-show-controls='["edit","delete"]' type="checkbox" data-checked="table-checked"
                value="{{$row["id"]}}">
            <label class="pl-4 custom-control-label" for="table-check-{{$row["id"]}}"></label>
        </div>
    </td>
    @endif
    <td class="text-left id">{{ $row["id"]}}</td>
    <td class="text-left name"> {{ $row["node"]["name"]}}</td>
    <td class="gender">{{mb_substr($row["node"]["node"]["gender"]["name"], 0, 1,'utf-8')}}</td>
    @foreach ($row['scores'] as $key => $scores)

    <td class="{{$scores["pass_or_fail"] == "fail" ? "bg-gray text-white" : "" }}">
        <span>{{$scores["marks"]}}</span>
    </td>


    @endforeach
    <td class="total_marks">
        {{$row['total_marks']}}
    </td>
    <td class="average"> {{$row["average"]}}</td>
    <td class="grade"> {{$row["grade"]}}</td>
</tr>
@endforeach
