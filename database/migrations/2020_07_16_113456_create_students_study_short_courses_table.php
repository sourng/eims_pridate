<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsStudyShortCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_study_short_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('stu_sh_c_request_id')->unsigned()->nullable();
            $table->bigInteger('stu_sh_c_session_id')->unsigned()->nullable();
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('students_study_short_courses');
    }
}
