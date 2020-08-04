<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="row shortcuts">

                    @foreach ($shortcut as $item)
                    <a data-loadscript='["{{asset("/assets/vendor/list.js/dist/list.min.js")}}","{{asset("/assets/vendor/pagination/simplePagination.js")}}"]' data-toggle="shortcut-icon" href="{{$item['link']}}" class="col-lg-2 col-6 shortcut-item">
                        <span class="shortcut-media avatar avatar-xl rounded mb-3 {{$item['color']}}">
                            @if ($item['icon'])
                            <i class="fa-2x {{$item['icon']}}"></i>
                            @else
                            <span class="w-100 text-xs">{{$item['text']}}</span>
                            @endif
                        </span>
                        <h4 class="text-sm">{{$item['name']}}</h4>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
