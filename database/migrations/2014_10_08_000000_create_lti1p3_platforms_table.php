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
        Schema::create('lti1p3_platforms', function (Blueprint $table) {
            $table->id();
            $table->string('local_name', 2000);
            $table->string('issuer_id')->index();
            $table->string('client_id')->index();
            $table->string('authorization_url', 3000);
            $table->string('authentication_url', 3000);
            $table->string('lti_advantage_token_url', 3000)->nullable();
            $table->boolean('deployment_id_autoregister')->default(true);
            $table->string('json_webkey_url');
            $table->string('signature_method');
            $table->string('guid')->nullable();
            $table->string('name', 2000)->nullable();
            $table->string('version')->nullable();
            $table->string('product_family_code')->nullable();
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
        Schema::dropIfExists('lti1p3_platforms');
    }
};
