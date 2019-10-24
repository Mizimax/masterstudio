<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateAchievementsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{

			Schema::create('achievements', function (Blueprint $table) {
				$table->bigIncrements('achievement_id');
				$table->string('achievement_pic');
				$table->string('achievement_name');
				$table->string('achievement_text');
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
			Schema::dropIfExists('achievementse');
		}
	}
