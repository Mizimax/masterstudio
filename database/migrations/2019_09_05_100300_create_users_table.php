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
	        $table->bigIncrements('user_id');
	        $table->bigInteger('master_id')->unsigned()->nullable();
	        $table->string('user_name');
	        $table->string('user_email')->unique();
            $table->timestamp('email_verified_at')->nullable();
	        $table->string('user_password');
	        $table->string('user_pic')->default('/img/profile.jpg');
	        $table->bigInteger('user_coin')->default(0);
	        $table->bigInteger('user_exp')->default(0);
	        $table->integer('user_level')->default(1);
	        $table->enum('user_type', ['user', 'master', 'admin'])->default('user');
	        $table->boolean('activity_week_viewed')->default(0); // 7 day retention 0 = not view 1 = viewed
            $table->rememberToken();
            $table->timestamps();

	        $table->foreign('master_id')->references('master_id')->on('masters')->onDelete('set null');
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
