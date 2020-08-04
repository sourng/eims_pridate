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
