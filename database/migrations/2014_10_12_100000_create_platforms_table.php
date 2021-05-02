<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platforms', function (Blueprint $table) {
            $table->id();
            $table->string('record_name');
            $table->string('issuer_id')->index();
            $table->string('client_id')->index();
            $table->string('deployment_id');
            $table->string('authorization_url');
            $table->string('authentication_url');
            $table->string('json_webkey_url');
            $table->string('signature_method');
            $table->string('guid')->nullable();
            $table->string('name')->nullable();
            $table->string('target_link_uri')->nullable();
            $table->string('version')->nullable();
            $table->string('product_family_code')->nullable();
            $table->string('validation_context')->nullable();
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
        Schema::dropIfExists('platforms');
    }
}
