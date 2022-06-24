<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instances', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('platform_id');
            $table->foreignId('deployment_id');
            $table->foreignId('context_id');
            $table->foreignId('resource_link_id')->nullable();
            $table->foreignId('user_id');
            $table->text('initial_message');
            $table->timestamp('created_at');
            $table->foreign('platform_id')->references('id')->on('platforms')->onDelete('cascade');
            $table->foreign('deployment_id')->references('id')->on('deployments')->onDelete('cascade');
            $table->foreign('context_id')->references('id')->on('contexts')->onDelete('cascade');
            $table->foreign('resource_link_id')->references('id')->on('resource_links')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instances');
    }
}
