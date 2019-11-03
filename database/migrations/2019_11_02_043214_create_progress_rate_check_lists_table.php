<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressRateCheckListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_rate_check_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('school_id');
            $table->string('teacher_computer');
            $table->string('student_computer');
            $table->string('quantity_teacher_desk');
            $table->string('quantity_student_desk');
            $table->string('size_ecc_length');
            $table->string('size_ecc_width');
            $table->string('power_socket_l');
            $table->string('power_socket_r');
            $table->string('power_socket_f');
            $table->string('power_socket_b');
            $table->string('circuit_breaker');
            $table->string('internet');
            $table->string('remark');

            $table->index('user_id');
            $table->index('region_id');
            $table->index('district_id');
            $table->index('school_id');

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
        Schema::dropIfExists('progress_rate_check_lists');
    }
}
