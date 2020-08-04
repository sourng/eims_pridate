@foreach ($response["data"] as $key => $row)

<tr class="{{ $row["total_all"] >= 5 ? "bg-gray text-white" : ""  }}">
    <td class="text-center id">{{ $row["node"]["id"]}}</td>
    <td class="text-left px-2 name"> {{ $row["node"]["name"]}}</td>
    <td class="text-center">{{mb_substr($row["node"]["node"]["gender"]["name"], 0, 1,'utf-8')}}</td>
    @for ($i = 1; $i <= DateHelper::daysOfMonth(request("year"),request("month")); $i++)
        @include(config("pages.parent").".includes.teaching.includes.attendance.includes.subbody.d") @endfor <td
        class="text-center" data-total-permission> {{$row["total_p"]}}</td>
        <td class="text-center" data-total-absent> {{$row["total_a"]}}</td>
        <td class="text-center" data-total-all> {{$row["total_all"]}}</td>
</tr>
@endforeach
