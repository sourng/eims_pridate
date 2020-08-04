<div class="card-body">
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
                @include(config("pages.parent").".includes.view.includes.subbody.a")
            </div>
        </div>
    </div>
</div>
