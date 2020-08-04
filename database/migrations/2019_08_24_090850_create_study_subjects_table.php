<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudySubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('institute_id')->unsigned()->nullable();
            $table->bigInteger('course_type_id')->unsigned()->nullable();
            $table->string('name')->unique();
            $table->string('en')->nullable();
            $table->string('km')->nullable();
            $table->string('file')->nullable();
            $table->float('full_mark_theory')->nullable();
            $table->float('pass_mark_theory')->nullable();
            $table->float('full_mark_practical')->nullable();
            $table->float('pass_mark_practical')->nullable();
            $table->integer('credit_hour')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('study_subjects');
    }
}
