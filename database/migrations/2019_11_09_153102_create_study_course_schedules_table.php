<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyCourseSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_course_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('institute_id')->unsigned()->nullable();
            $table->bigInteger('study_program_id')->unsigned()->nullable();
            $table->bigInteger('study_course_id')->unsigned()->nullable();
            $table->bigInteger('study_generation_id')->unsigned()->nullable();
            $table->bigInteger('study_academic_year_id')->unsigned()->nullable();
            $table->bigInteger('study_semester_id')->unsigned()->nullable();
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
        Schema::dropIfExists('study_course_schedules');
    }
}
