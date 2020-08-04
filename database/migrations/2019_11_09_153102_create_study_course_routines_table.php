<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyCourseRoutinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_course_routines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('study_course_session_id')->unsigned()->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->bigInteger('day_id')->unsigned()->nullable();
            $table->bigInteger('study_subject_id')->unsigned()->nullable();
            $table->bigInteger('teacher_id')->unsigned()->nullable();
            $table->bigInteger('study_class_id')->unsigned()->nullable();
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
        Schema::dropIfExists('study_course_routines');
    }
}
