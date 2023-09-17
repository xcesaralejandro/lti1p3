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
        Schema::create('lti1p3_user_roles', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('lti1p3_context_id')->nullable();
            $table->foreignId('lti1p3_user_id');
            $table->text('name');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('lti1p3_context_id')->references('id')->on('lti1p3_contexts')->onDelete('cascade');
            $table->foreign('lti1p3_user_id')->references('id')->on('lti1p3_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lti1p3_user_roles');
    }
};
