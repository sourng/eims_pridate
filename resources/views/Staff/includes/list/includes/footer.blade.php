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


</div>
