<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->unsignedInteger('document_type_id');
            $table->string('document', 12);
            $table->string('first_name', 60);
            $table->string('last_name', 60)->nullable();
            $table->string('company', 60)->nullable();
            $table->string('email_address', 80)->unique();
            $table->string('address', 100)->nullable();
            $table->string('city', 50);
            $table->string('province', 50);
            $table->string('country', 2);
            $table->string('phone', 30)->nullable();
            $table->string('mobile', 30)->nullable();
            $table->string('password')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps();

            $table->foreign('document_type_id')->references('id')->on('document_types');
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
