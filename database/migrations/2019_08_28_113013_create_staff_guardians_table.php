<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffGuardiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_guardians', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('staff_id')->unsigned()->nullable();
            $table->string('father_fullname')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('father_email')->nullable();
            $table->string('father_occupation')->nullable();
            $table->text('father_extra_info')->nullable();
            $table->string('mother_fullname')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('mother_email')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->text('mother_extra_info')->nullable();
            $table->string('guardian_is')->nullable();
            $table->string('guardian_fullname')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('guardian_occupation')->nullable();
            $table->text('guardian_extra_info')->nullable();
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
        Schema::dropIfExists('staff_guardians');
    }
}
