<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsStudyCourseScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_study_course_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('student_study_course_id')->unsigned()->nullable();
            $table->float('attendance_marks')->nullable()->default(0);
            $table->float('other_marks')->nullable()->default(0);
            $table->integer('grade')->nullable();
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
        Schema::dropIfExists('students_study_course_scores');
    }
}
