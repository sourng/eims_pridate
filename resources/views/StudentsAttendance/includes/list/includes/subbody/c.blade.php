
@foreach ($response["data"] as $key => $row)
    <tr data-id="{{$row["id"]}}" class="{{ $row["total_all"] >= 5 ? "bg-gray text-white" : ""  }}">
        @if (config("pages.parameters.param1") != "report")
        <td>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" data-toggle="table-checked" id="table-check-{{$row["id"]}}"
                    data-checked-show-controls='[]' type="checkbox" data-checked="table-checked"
                    value="{{$row["id"]}}">
                <label class="pl-4 custom-control-label" for="table-check-{{$row["id"]}}"></label>
            </div>
        </td>
        @endif
        <td class="text-center id">{{ $row["node"]["id"]}}</td>
        <td class="text-left name"> {{ $row["node"]["name"]}}</td>
        <td class="text-center">{{mb_substr($row["node"]["node"]["gender"]["name"], 0, 1,'utf-8')}}</td>
        @for ($i = 1; $i <= DateHelper::daysOfMonth(request("year"),request("month")); $i++)
            @include("StudentsAttendance.includes.list.includes.subbody.d")
        @endfor
        <td class="text-center" data-total-permission> {{$row["total_p"]}}</td>
        <td class="text-center" data-total-absent> {{$row["total_a"]}}</td>
        <td class="text-center" data-total-all> {{$row["total_all"]}}</td>
    </tr>
@endforeach
