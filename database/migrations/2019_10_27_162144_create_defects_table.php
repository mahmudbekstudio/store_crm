<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('date');
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('from_user_id');
            $table->unsignedBigInteger('received_user_id');

            $table->boolean('goods1_id')->default(false);
            $table->boolean('goods2_id')->default(false);
            $table->boolean('goods3_id')->default(false);
            $table->boolean('goods4_id')->default(false);
            $table->boolean('goods5_id')->default(false);
            $table->boolean('goods6_id')->default(false);
            $table->boolean('goods7_id')->default(false);

            $table->text('comment');
            $table->boolean('replacement_of_part')->default(false);
            $table->boolean('recovery')->default(false);
            $table->boolean('replacement_of_pc')->default(false);
            $table->string('date_of_done');
            $table->unsignedBigInteger('manager_id');

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
        Schema::dropIfExists('defects');
    }
}
