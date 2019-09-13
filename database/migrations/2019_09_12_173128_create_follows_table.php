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
				$table->bigInteger('following_id');
				$table->bigInteger('follower_id');
				$table->enum('follow_type', ['user', 'master']);
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
			Schema::dropIfExists('follows');
		}
	}
