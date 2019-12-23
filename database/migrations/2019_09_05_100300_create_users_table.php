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
	        $table->date('user_birth');
	        $table->string('user_pic')->default('/img/profile.jpg');
	        $table->text('user_goal')->nullable();
	        $table->tinyInteger('user_base_in_th')->nullable(); //0 ไม่,1 ใช่,2 both
	        $table->tinyInteger('user_interest_type')->nullable(); //0 Group,1 Solo,2 both
	        $table->tinyInteger('user_prof_rate')->nullable(); //1-7
	        $table->bigInteger('user_coin')->default(0);
	        $table->bigInteger('user_exp')->default(0);
	        $table->bigInteger('user_hour')->default(0);
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
