<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateUserActivitiesTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{

			Schema::create('user_activities', function (Blueprint $table) {
				$table->bigIncrements('user_activity_id');
				$table->bigInteger('activity_id')->unsigned();
				$table->bigInteger('user_id')->unsigned();
				// 0 =
				$table->tinyInteger('user_activity_status')->default(0);
				$table->timestamps();

				$table->foreign('activity_id')->references('activity_id')->on('activities');
				$table->foreign('user_id')->references('user_id')->on('users');

			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('user_activities');
		}
	}
