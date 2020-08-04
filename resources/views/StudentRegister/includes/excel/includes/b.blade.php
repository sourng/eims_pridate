<form action="{{str_replace("/add","excel/import",config("pages.form.action.add"))}}" enctype="multipart/form-data"
    method="POST" id="form-execute" novalidate data-console="#console" data-show-errors="#show-errors" data-validation="{{json_encode(config('pages.form.validate'))}}">
    @csrf
    <div class="card">
        <div class="card-header p-2 px-3">
            <label class="label-arrow label-primary label-arrow-right">
                (B) បញ្ចូលឯកសារ
            </label>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-file-excel"></i>
                                </span>
                            </div>
                            <input type="file" class="form-control" id="file" name="file" accept=".xls,.xlsx"
                                {{config("pages.form.validate.rules.file") ? "required" : ""}} />


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary  float-right" type="submit">
                <i class="fas fa-play"></i> ដំណើរការ
            </button>
        </div>
    </div>
</form>
