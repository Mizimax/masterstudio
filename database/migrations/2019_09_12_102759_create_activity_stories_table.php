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
				$table->bigIncrements('activity_id');
				$table->bigIncrements('user_id');
				$table->string('activity_story_video');
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
			Schema::dropIfExists('activity_stories');
		}
	}
