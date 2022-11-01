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
        Schema::create('exercises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->nullable(false);
            $table->tinyText('description')->nullable();
            $table->string('file', 255)->nullable(false);
            $table->unsignedInteger('creator_id')->nullable(false);
            $table->datetime('start_time')->useCurrent();
            $table->datetime('end_time')->useCurrent();
            $table->boolean('is_published')->nullable(false)->default(0);
            $table->timestamps();
            
            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercises');
    }
};
