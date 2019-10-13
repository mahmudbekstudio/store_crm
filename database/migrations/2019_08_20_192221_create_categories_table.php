<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->default(0);
            $table->unsignedBigInteger('template_id')->default(0);
            $table->unsignedTinyInteger('status')->default(0);
            $table->enum('step', array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'))->default('0');
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->unsignedBigInteger('type_id')->default(0);
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
            $table->index('parent_id');
            $table->index('type_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
