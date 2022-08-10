<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOfferSubmitRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offer_submit_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('device_id')->nullable();
            $table->text('title')->nullable();
            $table->text('text')->nullable();
            $table->string('file_name',400)->nullable();
            $table->string('email',400)->nullable();
            $table->string('mobile_number',400)->nullable();
            $table->string('phone_number',400)->nullable();
            $table->enum('status',['new','reviewed','accepted','rejected'])->default('new');
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
        Schema::dropIfExists('job_offer_submit_requests');
    }
}
