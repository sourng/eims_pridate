<div class="tab-pane fade show active" id="a" role="tabpanel" aria-labelledby="a-tab">
    <div class="row">
        <div class="col-10">
            <div class="form-group row">
                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("first_name_km")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["first_name_km"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("last_name_km")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["last_name_km"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("first_name_en")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["first_name_en"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("last_name_en")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["last_name_en"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("gender")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["gender"]["name"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("date_of_birth")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["date_of_birth"]}}</div>
                </div>


                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("nationality")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["nationality"]["name"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("national_id")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["national_id"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("mother_tong")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["mother_tong"]["name"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("blood_group")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["blood_group"]["name"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("blood_group")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["blood_group"]["name"]}}</div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("permanent_address")}}</label>
                <div class="col-sm-9 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["permanent_address"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("temporaray_address")}}</label>
                <div class="col-sm-9 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["temporaray_address"]}}</div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("phone")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">{{$row["phone"]}}
                    </div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("email")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">{{$row["email"]}}
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("father_fullname")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["student_guardian"]["father"]["name"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("occupation")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["student_guardian"]["father"]["occupation"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("father_phone")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["student_guardian"]["father"]["phone"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("father_email")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["student_guardian"]["father"]["email"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("mother_fullname")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["student_guardian"]["mother"]["name"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("occupation")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["student_guardian"]["mother"]["occupation"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("mother_phone")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["student_guardian"]["mother"]["phone"]}}</div>
                </div>

                <label class="col-sm-3 px-0 col-form-label">{{Translator::phrase("mother_email")}}</label>
                <div class="col-sm-3 px-0">
                    <div class="font-weight-bold form-control-plaintext">
                        {{$row["student_guardian"]["mother"]["email"]}}</div>
                </div>
            </div>
        </div>
        <div class="col-2">
            <img class="img-thumbnail" data-src="{{$row["photo"]}}" alt="" />
        </div>
    </div>
</div>
