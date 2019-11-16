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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_img')->default('avatar.png')->nullable();
            $table->string('cover_img')->default('avatar.png')->nullable();
            $table->boolean('active')->default(false);
            $table->string('activation_token');
            $table->string('password');
            // $table->unsignedInteger('visitors')->default(0);  
            // $table->unsignedInteger('likes')->default(0);
            // $table->unsignedInteger('following')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
