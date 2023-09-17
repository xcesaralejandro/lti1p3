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
        Schema::create('lti1p3_users', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('lti1p3_platform_id')->nullable();
            $table->uuid('lti_id')->index()->nullable();
            $table->string('password')->nullable();
            $table->string('name')->nullable();
            $table->string('given_name')->nullable();
            $table->string('family_name')->nullable();
            $table->string('email')->nullable();
            $table->string('picture')->nullable();
            $table->string('person_sourceid')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('lti1p3_users');
    }
};
