<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateActivityStoriesTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{

			Schema::create('activity_stories', function (Blueprint $table) {
				$table->bigIncrements('activity_story_id');
				$table->bigInteger('activity_id')->unsigned();
				$table->bigInteger('user_id')->unsigned();
				$table->text('activity_story_video');
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
			Schema::dropIfExists('activity_stories');
		}
	}
