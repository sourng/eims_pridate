<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyCourseSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_course_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('study_course_schedule_id')->unsigned()->nullable();
            $table->bigInteger('study_session_id')->unsigned()->nullable();
            $table->date('study_start')->nullable();
            $table->date('study_end')->nullable();
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
        Schema::dropIfExists('study_course_sessions');
    }
}
