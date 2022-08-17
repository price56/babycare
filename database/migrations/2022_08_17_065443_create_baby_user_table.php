<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baby_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->comment('유저 아이디');
            $table->unsignedBigInteger('baby_id')->comment('아기 아이디');
            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onDelete('CASCADE');
            $table->foreign('baby_id')
                ->on('babies')
                ->references('id')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baby_user');
    }
};
