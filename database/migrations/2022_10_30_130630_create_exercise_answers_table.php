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
        Schema::create('exercise_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exercise_id')->nullable(false);
            $table->unsignedInteger('user_id')->nullable(false);
            $table->string('answer_file', 255)->nullable();
            $table->datetime('answer_time')->useCurrent();
            $table->boolean('is_done')->nullable(false)->default(0);
            $table->timestamps();

            $table->foreign('exercise_id')->references('id')->on('exercises');
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
        Schema::dropIfExists('exercise_answers');
    }
};
