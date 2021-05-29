<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theme_settings', function (Blueprint $table) {
          $table->increments('id');
          $table->string('tenant_title')->nullable();
          $table->string('tenant_description')->nullable();
          $table->string('tenant_image')->nullable();
          $table->string('datetime_format')->nullable();
          $table->string('phone_format')->nullable();
          $table->string('smtp_website_name')->nullable();
          $table->string('smtp_server')->nullable();
          $table->string('smtp_port')->nullable();
          $table->string('smtp_email')->nullable();
          $table->string('smtp_email_pass')->nullable();
          $table->string('smtp_from_name')->nullable();
          $table->string('smtp_from_email')->nullable();
          $table->string('smtp_transport_exp')->nullable();
          $table->string('smtp_encryption')->nullable();
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
        Schema::dropIfExists('theme_settings');
    }
}
