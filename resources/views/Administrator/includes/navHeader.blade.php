<!-- Header -->
<div class="header bg-{{config("app.theme_color.name")}} pb-6"
data-theme-bg-color="{{config("app.theme_color.name")}}">
<div class="container-fluid">
    <div class="header-body">
        <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">{{Translator::phrase("dashboard")}} </h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item text-white"><i class="fas fa-home"></i></li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
                <a href="{{url()->current()}}" class="btn btn-secondary btn-sm"
                    data-toggle="cotent-refresh"><i class="fas fa-sync-alt"></i></a>
            </div>
        </div>
    </div>
</div>
</div>
