<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->default(0);
            $table->unsignedTinyInteger('status')->default(1);// 0 or 1 (not active or active)
            $table->string('title');
            $table->string('name');// unique in website
            $table->enum('type', array('post', 'category'))->default('post');
            $table->unsignedTinyInteger('has_parent')->default(0);// 0 or 1, if post or category has parent set 1
            $table->unsignedInteger('child_of')->default(0);//only for post type, put category id for post, if post type has category
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique('name');
            $table->index('type');
            $table->index('child_of');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types');
    }
}
