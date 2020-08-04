<div class="card-footer">
    <div class="table-responsive">
        <table class="table table-bordered mb-2" style="width:unset" id="t2">
            <tbody>
                @foreach ($response["gender"] as $key => $gender)
                <tr>
                    <td class="text-left p-2">{{  $gender['title'] }}</td>
                    <td class="text-right p-2">{{ $gender['text']}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>

        <table class="table table-bordered" style="width:unset" id="t3">
            <tbody>
                <tr>
                    @foreach ($response["staffStatus"] as $key => $status)
                    <td class="text-left p-2 {{$status['color']}}">{{ $status['title'] }}</td>
                    <td class="text-right p-2 {{$status['color']}}">{{ $status['text'] }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>



    <div class="mt-3 pull-right">
        @if($response["success"])
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
