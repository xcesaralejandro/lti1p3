<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('platform_id')->nullable();
            $table->uuid('lti_id')->index()->nullable();
            $table->string('password')->nullable();
            $table->string('name')->nullable();
            $table->string('given_name')->nullable();
            $table->string('family_name')->nullable();
            $table->string('email')->nullable();
            $table->string('picture')->nullable();
            $table->text('roles')->nullable();
            $table->string('person_sourceid')->nullable();
            $table->enum('creation_method',['LTI','MANUAL'])->default('LTI');
            $table->enum('app_role',['ADMIN','DEFAULT'])->default('DEFAULT');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('platform_id')->references('id')->on('platforms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
