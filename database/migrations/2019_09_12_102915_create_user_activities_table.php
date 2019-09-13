<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateActivityJoinTable extends Migration
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
				$table->bigIncrements('activity_id');
				$table->bigIncrements('user_id');
				// 0 =
				$table->tinyInteger('user_activity_status')->default(0);
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
			Schema::dropIfExists('activity_join');
		}
	}
