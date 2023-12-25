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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('avatar')->nullable();
            $table->string('user_name')->nullable(false)->unique();
            $table->string('rfid')->nullable(false)->unique();
            $table->timestamp('birthday')->nullable(false);
            $table->string('fullname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('role')->nullable();
            $table->string('password');
            $table->string('address')->nullable(false);
            $table->string('phone')->nullable(false)->unique();
            $table->smallInteger('gender');
            $table->string('id_number')->nullable(false)->unique();
            $table->string('medical_insurance');
            $table->boolean('password_changed')->default(false);
            $table->rememberToken();
            $table->timestamps();
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
};
