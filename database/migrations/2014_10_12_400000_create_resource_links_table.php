<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('context_id');
            $table->string('lti_id')->index();
            $table->text('description')->nullable();
            $table->string('title')->nullable();
            $table->string('validation_context')->nullable();
            $table->timestamps();
            $table->foreign('context_id')->references('id')->on('contexts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_links');
    }
}
