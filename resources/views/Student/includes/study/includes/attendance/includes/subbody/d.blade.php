@php
use Carbon\Carbon;
$setClass = DateHelper::getDate(request("year").'-'.request("month").'-'.$i)->isToday() ? "bg-blue text-white text-center" : "text-center" ;
$setText= null ;
$setTitle= null ;
$setToggle   = null;
$study_start = new Carbon($row['schedule']['study_start']);
$study_end   = new Carbon($row['schedule']['study_end']);
$modify =  request('year').'-'.request('month').'-'.$i;

if($study_start->diff($modify)->invert == 0){
    $modify = new Carbon($modify);
    if($modify->diff(DateHelper::convert($study_end))->invert == 0){
        //$setToggle = 'data-toggle=attendance';
    }
}
@endphp
@if(array_key_exists($i ,$holiday))
    @if($holiday[$i]["id"]== null)
        @php
            $setClass= "bg-pink text-center text-white merge";
            $setText=Translator::phrase("holiday");
            $setTitle=$holiday[$i]["description"];
        @endphp
    @else
        @php
            $setClass="bg-green text-center text-white merge" ;
            $setText=Translator::phrase("national_holiday");
            $setTitle=$holiday[$i]["description"];
        @endphp
    @endif
@endif

@if (array_key_exists($i,$row["date"]))
<td data-toggle="tooltip" rel="tooltip" data-placement="left" class="{{ $setClass  }}" title="{{ $setTitle }}">
    @if(array_key_exists($i ,$holiday))
        <div class="rotate" style="writing-mode: vertical-rl; text-orientation: mixed; transform: rotate(-180deg);margin: auto;">
            <p style="margin: 0rem;">
                {{$setText}}
            </p>
        </div>
    @else
        <div data-url="{{ $row["action"]["edit"] }}"
            title="{{ (app()->getLocale() == "km"? "ថ្ងៃ": ""). Translator::day(DateHelper::dayOfWeek(request("year").'-'.request("month").'-'.$i)["day"]) }} - {{app()->getLocale() == "km" ? "ទី" .$i : $i}}"
            {{$setToggle}}  data-id="{{ $row["node"]["id"]}}" data-date="{{ $i }}"
            data-key="{{$row["date"][$i]["attendance"]["id"]}}">
            <span data-toggle="tooltip" rel="tooltip" data-placement="left"
                title="{{$row["date"][$i]["attendance"]["name"]}}">{{$row["date"][$i]["attendance"]["credit_absent"]}}</span>
        </div>
    @endif
</td>
@else
<td data-toggle="tooltip" rel="tooltip" data-placement="left" class="{{ $setClass  }}"
    title="{{ $setTitle }}">

    @if(array_key_exists($i ,$holiday))
        <div class="rotate" style="writing-mode: vertical-rl; text-orientation: mixed;transform: rotate(-180deg);margin: auto;">
            <p style="margin: 0rem;font-size:0.8125rem">
                {{$setText}}
            </p>
        </div>
    @endif
</td>
@endif
