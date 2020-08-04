<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->nullable();
            $table->text('en')->nullable();
            $table->text('km')->nullable();
            $table->bigInteger('institute_id')->unsigned()->nullable();
            $table->bigInteger('study_faculty_id')->unsigned()->nullable();
            $table->bigInteger('course_type_id')->unsigned()->nullable();
            $table->bigInteger('study_modality_id')->unsigned()->nullable();
            $table->bigInteger('study_program_id')->unsigned()->nullable();
            $table->bigInteger('study_overall_fund_id')->unsigned()->nullable();
            $table->bigInteger('curriculum_endorsement_id')->unsigned()->nullable();
            $table->bigInteger('curriculum_author_id')->unsigned()->nullable();
            $table->bigInteger('study_generation_id')->unsigned()->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->text('image')->nullable();

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
        Schema::dropIfExists('study_courses');
    }
}
