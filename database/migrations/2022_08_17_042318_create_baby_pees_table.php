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
        Schema::create('baby_pees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('baby_id')->comment('아기 아이디');
            $table->enum('type', ['large', 'small']);
            $table->boolean('success_yn')->default(false);
            $table->text('description')->nullable();
            $table->dateTime('event_time_at')->comment('변 본 시간');
            $table->timestamps();
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
        Schema::dropIfExists('baby_pees');
    }
};
