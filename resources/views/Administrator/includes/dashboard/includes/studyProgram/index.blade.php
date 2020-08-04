@php
$setClass = "";
$setId = "";
@endphp
@foreach ($studyProgram as $key => $item)
@if (($key + 1) > 6)
@php
$setClass = "collapse";
$setId = "studyProgram-more";
@endphp
@else
@php
$setClass = "";
$setId = "";
@endphp
@endif
@include(Auth::user()->role('view_path').".includes.dashboard.includes.studyProgram.includes.a")

@if (count($studyProgram) == ($key + 1))
<a class="btn btn-sm text-white" data-toggle="collapse" href="#studyProgram-more" role="button" aria-expanded="false"
    aria-controls="studyProgram-more">
    {{Translator::phrase("more")}}
</a>
@endif
@endforeach
