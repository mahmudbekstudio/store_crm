<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->default(0);
            $table->unsignedBigInteger('type_id');

            $table->string('label');
            $table->string('name');
            $table->string('field_type');
            $table->longText('field_params');
            $table->string('description');
            $table->tinyInteger('required')->default(0);
            $table->string('default_value');
            $table->string('placeholder');
            $table->enum('tab', array('main', 'fields', 'seo', 'extra'))->default('main');// axists fields for type
            $table->tinyInteger('active')->default(0);// 1 or 0 (active or not active)
            $table->tinyInteger('ordering')->default(0);// ordering fields
            $table->timestamps();

            $table->index('type_id');
            $table->index('ordering');
            $table->index('active');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_metas');
    }
}
