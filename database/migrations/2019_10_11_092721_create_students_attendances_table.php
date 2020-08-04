<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('student_study_course_id')->unsigned()->nullable();
            $table->bigInteger('attendance_type_id')->unsigned()->nullable();
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('date')->nullable();
            $table->text('create_by')->nullable();
            $table->text('from_by')->nullable();
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
        Schema::dropIfExists('students_attendances');
    }
}
