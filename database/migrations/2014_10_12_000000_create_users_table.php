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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 255)->unique()->nullable(false);
            $table->string('password', 255)->nullable(false);
            $table->string('fullname', 255)->nullable(false);
            $table->string('avatar', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 10)->nullable();
            $table->boolean('is_teacher')->nullable(false)->default(0);
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
        Schema::dropIfExists('users');
    }
};
