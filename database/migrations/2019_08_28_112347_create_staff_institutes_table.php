<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffInstitutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_institutes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('staff_id')->unsigned();
            $table->bigInteger('institute_id')->unsigned()->nullable();
            $table->bigInteger('designation_id')->unsigned()->nullable();
            $table->text('extra_info')->nullable();
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
        Schema::dropIfExists('staff_institutes');
    }
}
