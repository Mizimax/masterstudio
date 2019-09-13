<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateActivitiesTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('activities', function (Blueprint $table) {
				$table->bigIncrements('activity_id');
				$table->bigInteger('studio_id')->nullable();
				$table->bigInteger('master_id');
				$table->bigInteger('category_id');
				$table->bigInteger('achievement_id');
				$table->string('activity_video_action');
				$table->string('activity_name');
				$table->string('activity_description');
				$table->text('activity_prepare');
				$table->string('activity_difficult');
				$table->tinyInteger('activity_time_type')->default(0); // 0 = ครั้งเดียว 1 = เดือนๆ ปีๆ
				$table->dateTime('activity_apply_start');
				$table->dateTime('activity_apply_end')->nullable();
				$table->dateTime('activity_start');
				$table->dateTime('activity_end')->nullable();
				$table->int('activity_routine_day')->nullable(); //1234567 7day 0 is everyday
				$table->tinyInteger('activity_promo')->nullable();
				$table->integer('activity_hour');
				$table->integer('activity_price');
				$table->integer('activity_max');
				$table->string('activity_location_name');
				$table->string('activity_location')->nullable();
				$table->string('activity_suggest_name')->nullable();
				$table->int('activity_boost_priority')->nullable();
				$table->tinyInteger('activity_allow_comment')->default(0); //0 anyone 1 disciple
				$table->bigInteger('activity_guest_view')->default(0);
				$table->bigInteger('activity_user_view')->default(0);
				$table->bigInteger('activity_user_retention')->default(0);
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
			Schema::dropIfExists('activities');
		}
	}
