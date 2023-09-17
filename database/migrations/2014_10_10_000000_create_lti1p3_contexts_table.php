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
        Schema::create('lti1p3_contexts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deployment_id');
            $table->string('lti_id')->index();
            $table->string('label')->nullable();
            $table->string('title')->nullable();
            $table->text('type')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('deployment_id')->references('id')->on('lti1p3_deployments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lti1p3_contexts');
    }
};
