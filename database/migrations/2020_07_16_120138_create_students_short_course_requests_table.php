<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsShortCourseRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_short_course_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('student_id')->unsigned()->nullable();
            $table->bigInteger('institute_id')->unsigned()->nullable();
            $table->bigInteger('study_subject_id')->unsigned()->nullable();
            $table->bigInteger('study_session_id')->unsigned()->nullable();
            $table->string('description')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status',['1','0'])->default(0);

            $table->bigInteger('added_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

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
        Schema::dropIfExists('students_short_course_requests');
    }
}
