<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class StudioReview extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			//
			Schema::create('studio_reviews', function (Blueprint $table) {
				$table->bigIncrements('review_id');
				$table->bigInteger('studio_id')->unsigned();
				$table->bigInteger('user_id')->unsigned();
				$table->text('review_text');
				$table->timestamps();

				$table->foreign('studio_id')->references('studio_id')->on('studios');
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
			//
		}
	}
