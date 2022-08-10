<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('last_name', 350)->nullable();
            $table->string('user_name')->nullable();
            $table->string('chat_id')->nullable();
            $table->enum('status', ['active', 'block'])->default('active');
            $table->string('step', 50)->default('init')->nullable();
            $table->string('email', 450)->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->integer('prefix_number')->default(98)->nullable();
            $table->text('device_id')->nullable();
            $table->boolean('gender')->nullable();
            $table->string('state_id')->nullable();
            $table->text('password')->nullable();

            $table->timestamps();
            $table->softDeletes();
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
}
