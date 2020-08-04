<div class="card">
    @foreach ($staff as $key => $item)

    @include(Auth::user()->role('view_path').".includes.dashboard.includes.staff.includes.a")

    @endforeach
</div>
