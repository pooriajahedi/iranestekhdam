<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOfferContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offer_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('job_offer_id')->unsigned()->index();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->string('phone')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('registerLink')->nullable();
            $table->string('sms')->nullable();
            $table->string('telegram')->nullable();
            $table->string('website')->nullable();
            $table->string('whatsapp')->nullable();

            $table->timestamps();

            $table->foreign('job_offer_id')->references('id')->on('job_offers')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_offer_contacts');
    }
}
