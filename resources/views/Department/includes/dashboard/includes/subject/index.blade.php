@if ($current_subjects["success"])
<div class="card">
    @include(config("pages.parent").".includes.dashboard.includes.subject.includes.a",['response' =>
    $current_subjects])
</div>
@endif
