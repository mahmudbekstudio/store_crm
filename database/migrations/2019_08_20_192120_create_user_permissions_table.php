<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('access_action')->default('');
            $table->unsignedTinyInteger('action_create')->default(0);
            $table->unsignedTinyInteger('action_read')->default(0);
            $table->unsignedTinyInteger('action_update')->default(0);
            $table->unsignedTinyInteger('action_delete')->default(0);
            $table->unsignedTinyInteger('only_own')->default(1);// only own created records can access
            $table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('access_action');
            $table->index('action_create');
            $table->index('action_read');
            $table->index('action_update');
            $table->index('action_delete');
            $table->index('only_own');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_permissions');
    }
}
