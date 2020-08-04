<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('student_id')->unsigned()->nullable();
            $table->bigInteger('institute_id')->unsigned()->nullable();
            $table->bigInteger('study_program_id')->unsigned()->nullable();
            $table->bigInteger('study_course_id')->unsigned()->nullable();
            $table->bigInteger('study_generation_id')->unsigned()->nullable();
            $table->bigInteger('study_academic_year_id')->unsigned()->nullable();
            $table->bigInteger('study_semester_id')->unsigned()->nullable();
            $table->bigInteger('study_session_id')->unsigned()->nullable();
            $table->text('description')->nullable();
            $table->text('photo')->nullable();
            $table->enum('status', ['1', '0'])->default(0);
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
        Schema::dropIfExists('students_requests');
    }
}
