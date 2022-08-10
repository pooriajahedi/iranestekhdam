<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_category_id')->unsigned()->index();
            $table->text('device_id')->nullable();
            $table->text('subject')->nullable();
            $table->text('body')->nullable();
            $table->boolean('is_read')->default(true);
            $table->enum('status',['waiting','admin_answer','user_answer','closed'])->default('waiting');
            $table->enum('priority',['critical','high','normal','low'])->default('normal');
            $table->timestamps();

            $table->foreign('ticket_category_id')->references('id')->on('ticket_categories')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
