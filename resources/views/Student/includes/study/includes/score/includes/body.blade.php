<style>

    .custom-control {
        min-width: 1.5rem;
        padding-left: 0rem;
    }
    .custom-control-label::before {
        top: .25rem;
        left: 0.25rem;
    }

    .custom-control-label::after {
        top: .25rem;
        left: 0.25rem;
    }

    table th .custom-control {
        min-height: unset
    }

    table th label.custom-control-label {
        display: unset !important;
        vertical-align: super;
    }
</style>
<div class="card-body {{request()->segment(2) == "study" ? "py-0" : "p-0"}}">
    <div class="table-responsive" data-toggle="list" data-list-values='["id", "name"'>
        <table class="table table-bordered table-hover table-xs" id="t1 list-table">
            @include(config("pages.parent").".includes.study.includes.score.includes.subbody.a")
            @include(config("pages.parent").".includes.study.includes.score.includes.subbody.b")
        </table>
    </div>
</div>
