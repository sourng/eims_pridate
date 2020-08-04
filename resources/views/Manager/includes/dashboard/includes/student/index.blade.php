<div class="card">
    @foreach ($student as $key => $item)

    @include(Auth::user()->role('view_path').".includes.dashboard.includes.student.includes.a")

    @endforeach
</div>
