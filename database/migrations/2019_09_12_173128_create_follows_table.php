<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateFollowsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{

			Schema::create('follows', function (Blueprint $table) {
				$table->bigIncrements('follow_id');
				$table->bigInteger('following_id')->unsigned()->nullable();
				$table->bigInteger('follower_id')->unsigned();
				$table->bigInteger('studio_id')->unsigned()->nullable();
				$table->enum('follow_type', ['user', 'master', 'studio'])->default('user');
				$table->timestamps();

				$table->foreign('following_id')->references('user_id')->on('users');
				$table->foreign('follower_id')->references('user_id')->on('users');
				$table->foreign('studio_id')->references('studio_id')->on('studios');
				$table->unique(['following_id', 'follower_id']);
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('follows');
		}
	}
