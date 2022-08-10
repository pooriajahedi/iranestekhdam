<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_version')->nullable();
            $table->text('update_note')->nullable();
            $table->text('download_url')->nullable();
            $table->boolean('force_update')->default(0);
            $table->text('resume_url')->nullable();
            $table->text('share_text')->nullable();
            $table->text('about_text')->nullable();
            $table->text('address')->nullable();
            $table->text('email')->nullable();
            $table->text('tel')->nullable();
            $table->text('website')->nullable();
            $table->text('telegram_id')->nullable();
            $table->text('whats_app_number')->nullable();

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
        Schema::dropIfExists('app_infos');
    }
}
