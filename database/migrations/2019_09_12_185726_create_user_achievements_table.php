<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateUserAchievementsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{

			Schema::create('user_achievements', function (Blueprint $table) {
				$table->bigIncrements('user_achievement_id');
				$table->bigInteger('achievement_id')->unsigned();
				$table->bigInteger('user_id')->unsigned();
				$table->bigInteger('category_id')->unsigned();
				$table->timestamps();

				$table->foreign('achievement_id')->references('achievement_id')->on('achievements');
				$table->foreign('user_id')->references('user_id')->on('users');
				$table->foreign('category_id')->references('category_id')->on('categories');
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('user_achievements');
		}
	}
