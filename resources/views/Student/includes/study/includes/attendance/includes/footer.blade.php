<div class="card-body py-0 table-responsive {{config("pages.parameters.param1") == "report" ? "p-0" : ""}}">
    <table class="table table-bordered my-2" style="width:unset" id="t2">
        <tbody>
            @php
            $i = 1;
            @endphp
            @foreach ($response["gender"] as $key => $gender)
            <tr>
                <td class="text-left p-2">{{  $gender['title'] }}</td>
                <td class="text-right p-2">{{ $gender['text']}}</td>
                @if ($i == 1)
                <td class="text-right text-center print-option">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="table-option-t2" checked data-toggle="table-option"
                            type="checkbox">
                        <label class="custom-control-label" for="table-option-t2">
                            <span class="ml-4"></span>
                            <span class="">{{Translator::phrase("print")}}</span>
                        </label>
                    </div>
                </td>
                @endif
            </tr>
            @php
            $i++;
            @endphp
            @endforeach

        </tbody>
    </table>

    <table class="table table-bordered" style="width:unset" id="t3">
        <tbody>
            <tr>
                <td class="p-3 bg-blue"></td>
                <td class="text-left"> {{ Translator::phrase("today") }} </td>

                <td class="p-3 bg-green"></td>
                <td class="text-left"> {{ Translator::phrase("national_holiday") }} </td>

                <td class="p-3 text-left bg-pink"> </td>
                <td> {{ Translator::phrase("holiday") }} </td>

                <td class="p-3 bg-gray"> </td>
                <td class="text-left"> {{ Translator::phrase("most_absent") }} </td>

                <td class="text-right text-center print-option">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="table-option-t3" data-toggle="table-option" checked
                            type="checkbox">
                        <label class="custom-control-label" for="table-option-t3">
                            <span class="ml-4"></span>
                            <span class="">{{Translator::phrase("print")}}</span>
                        </label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>



</div>

<div class="card-footer">
    <div class="mt-3 pull-right">
        @if($response["success"] && array_key_exists('path',$response['pages']))
        <ul class="pagination justify-content-end" data-url="{{$response["pages"]["path"]}}"
            data-total-pages="{{$response["pages"]["last_page"]}}" data-total-items="{{$response["pages"]["total"]}}"
            data-per-pages="{{$response["pages"]["per_page"]}}"
            data-current-page="{{$response["pages"]["current_page"]}}" data-search-page="{{config("pages.search")}}"
            data-table="table#list-table">
        </ul>
        @else
        <ul class="pagination justify-content-end" data-url="#" data-total-pages=0 data-total-items=0 data-per-pages=0
            data-current-page=0>
        </ul>
        @endif
    </div>
</div>
