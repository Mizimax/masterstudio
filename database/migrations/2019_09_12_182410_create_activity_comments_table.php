<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateActivityCommentsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{

			Schema::create('activity_comments', function (Blueprint $table) {
				$table->bigIncrements('comment_id');
				$table->bigInteger('activity_id')->unsigned();
				$table->bigInteger('user_id')->unsigned();
				$table->text('comment_text');
				$table->integer('comment_agree')->default(0);
				$table->enum('comment_rate', ['most recommended', 'recommended']);
				$table->string('comment_pic_action');
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
			Schema::dropIfExists('activity_comments');
		}
	}
