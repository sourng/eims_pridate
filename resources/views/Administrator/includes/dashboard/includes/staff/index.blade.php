<div class="card">
    @foreach ($staff as $key => $item)
    @if (($key + 1) > 2)
    <div class="collapse" id="staff-more">
        @include(Auth::user()->role('view_path').".includes.dashboard.includes.staff.includes.a")
    </div>
    @else
    @include(Auth::user()->role('view_path').".includes.dashboard.includes.staff.includes.a")
    @endif

    @if (count($staff) == ($key + 1))
    <a class="btn btn-sm" data-toggle="collapse" href="#staff-more" role="button" aria-expanded="false"
        aria-controls="staff-more">
        {{Translator::phrase("more")}}
    </a>
    @endif
    @endforeach
</div>
