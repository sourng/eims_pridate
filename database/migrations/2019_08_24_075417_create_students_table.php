<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('institute_id')->unsigned()->nullable();
            $table->string('first_name_km')->nullable();
            $table->string('last_name_km')->nullable();
            $table->string('first_name_en')->nullable();
            $table->string('last_name_en')->nullable();
            $table->bigInteger('nationality_id')->unsigned()->nullable();
            $table->bigInteger('mother_tong_id')->unsigned()->nullable();
            $table->string('national_id')->nullable();
            $table->bigInteger('gender_id')->unsigned()->nullable();
            $table->date('date_of_birth')->nullable();
            $table->bigInteger('marital_id')->unsigned()->nullable();
            $table->bigInteger('blood_group_id')->unsigned()->nullable();

            $table->text('place_of_birth')->nullable();
            $table->text('current_resident')->nullable();
            $table->text('permanent_address')->nullable();
            $table->text('temporaray_address')->nullable();

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('extra_info')->nullable();
            $table->text('photo')->nullable();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
