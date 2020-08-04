<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name_km')->nullable();
            $table->string('last_name_km')->nullable();
            $table->string('first_name_en')->nullable();
            $table->string('last_name_en')->nullable();
            $table->bigInteger('nationality_id')->unsigned()->nullable();
            $table->bigInteger('mother_tong_id')->unsigned()->nullable();
            $table->integer('national_id')->nullable();
            $table->bigInteger('gender_id')->unsigned()->nullable();
            $table->date('date_of_birth')->nullable();
            $table->bigInteger('marital_id')->unsigned()->nullable();
            $table->bigInteger('blood_group_id')->unsigned()->nullable();

            $table->string('place_of_birth')->nullable();
            $table->string('current_resident')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('temporaray_address')->nullable();

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('extra_info')->nullable();
            $table->text('photo')->nullable();
            $table->bigInteger('staff_status_id')->unsigned()->nullable();
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
        Schema::dropIfExists('staff');
    }
}
