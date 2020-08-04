<div class="card-body p-0" style="text-align: initial">
    <div class="row">
        <div class="col">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="b-tab" data-toggle="tab" href="#a" role="tab" aria-controls="a"
                        aria-selected="true">
                        (A) {{Translator::phrase("biography")}}
                    </a>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                @include(config("pages.parent").".includes.print.includes.subbody.a")
            </div>
        </div>
    </div>
</div>
