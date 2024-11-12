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
        Schema::create('lti1p3_nonces', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('lti1p3_platform_id');
            $table->timestamps();
            $table->foreign('lti1p3_platform_id')->references('id')->on('lti1p3_platforms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lti1p3_nonces');
    }
};
