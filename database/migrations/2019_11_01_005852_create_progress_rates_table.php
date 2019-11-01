<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('school_id');
            $table->string('teacher_computer');
            $table->string('student_computer');
            $table->string('survey');
            $table->string('out_wh');
            $table->string('site_arrival_inspection');
            $table->string('installation');
            $table->string('oat_training');
            $table->string('oac');
            $table->string('mac');
            $table->string('warranty_completion');
            //- installed_quantity_ecc
            //- installed_quantity_pc
            $table->string('remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('progress_rates');
    }
}
