<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyAcademicYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_academic_years', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('institute_id')->unsigned()->nullable();
            $table->string('name')->unique();
            $table->string('en')->nullable();
            $table->string('km')->nullable();
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
        Schema::dropIfExists('study_academic_years');
    }
}
