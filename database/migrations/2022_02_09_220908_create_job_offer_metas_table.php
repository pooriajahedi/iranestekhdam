<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOfferMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offer_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('job_offer_id')->unsigned()->index();
            $table->bigInteger('value');

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
        Schema::dropIfExists('job_offer_metas');
    }
}
