<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAutomaticSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_automatic_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('state_id')->unsigned()->index();
            $table->bigInteger('gender_id')->unsigned()->index()->default(8595100);
            $table->bigInteger('work_time_id')->unsigned()->index()->default(8595200);
            $table->bigInteger('work_mode_id')->unsigned()->index()->default(8595300);
            $table->bigInteger('experience_type_id')->unsigned()->index()->default(8595400);
            $table->bigInteger('experience_time_id')->unsigned()->index()->default(8595400);
            $table->bigInteger('job_id')->unsigned()->index()->default(8595600);
            $table->bigInteger('education_id')->unsigned()->index()->default(8595700);
            $table->bigInteger('grade_id')->unsigned()->index()->default(8595500);
            $table->bigInteger('second_job_id')->unsigned()->index()->default(8595800);
            $table->bigInteger('second_education_id')->unsigned()->index()->default(8595900);
            $table->bigInteger('third_job_id')->unsigned()->index()->default(85951000);
            $table->bigInteger('third_education_id')->unsigned()->index()->default(85951100);
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('state_id')->references('service_id')->on('ctegories_combinations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('gender_id')->references('service_id')->on('ctegories_combinations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('work_time_id')->references('service_id')->on('ctegories_combinations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('work_mode_id')->references('service_id')->on('ctegories_combinations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('experience_type_id')->references('service_id')->on('ctegories_combinations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('experience_time_id')->references('service_id')->on('ctegories_combinations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('job_id')->references('service_id')->on('ctegories_combinations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('education_id')->references('service_id')->on('ctegories_combinations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('grade_id')->references('service_id')->on('ctegories_combinations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('second_job_id')->references('service_id')->on('ctegories_combinations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('second_education_id')->references('service_id')->on('ctegories_combinations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('third_job_id')->references('service_id')->on('ctegories_combinations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('third_education_id')->references('service_id')->on('ctegories_combinations')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_automatic_subscriptions');
    }
}
