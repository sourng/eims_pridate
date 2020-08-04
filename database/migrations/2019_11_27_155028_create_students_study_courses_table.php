<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsStudyCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_study_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('nid')->nullable();
            $table->bigInteger('student_request_id')->unsigned()->nullable();
            $table->bigInteger('study_course_session_id')->unsigned()->nullable();
            $table->bigInteger('study_status_id')->unsigned()->nullable();
            $table->text('description')->nullable();
            $table->text('photo')->nullable();
            $table->text('qrcode')->nullable();
            $table->text('card')->nullable();
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
        Schema::dropIfExists('students_study_courses');
    }
}
