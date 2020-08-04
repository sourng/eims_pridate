<div class="card m-0">
    <div class="card-header py-2 px-3">
        {{config("pages.form.data.name")}} | {{Translator::phrase(config("pages.form.data.layout"))}}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <img class="w-100" data-src="{{config("pages.form.data.front_o")}}" alt="">
            </div>
            <div class="col">
                <img class="w-100" data-src="{{config("pages.form.data.background_o")}}" alt="">
            </div>
        </div>
    </div>
</div>
