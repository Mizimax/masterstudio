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
				$table->bigInteger('user_id')->unsigned();
				$table->bigInteger('category_id')->unsigned();
				$table->bigInteger('achievement_id')->unsigned();
				$table->text('activity_video')->default('[]'); //ARRAY
				$table->string('activity_name');
				$table->string('activity_url_name')->unique();
				$table->text('activity_description');
				$table->text('activity_benefit')->default('[]'); //ARRAY
				$table->text('activity_prepare');
				$table->string('activity_difficult'); //basic advance
				$table->tinyInteger('activity_time_type')->default(0); // 0 = ครั้งเดียว 1 = เดือนๆ ปีๆ
				$table->date('activity_apply_start');
				$table->date('activity_apply_end')->nullable();
				$table->date('activity_start');
				$table->date('activity_end')->nullable();
				$table->string('activity_routine_day'); //1234567 7day 0 is everyday
				$table->string('activity_time_start');
				$table->string('activity_time_end');
				$table->tinyInteger('activity_promo')->nullable();
				$table->integer('activity_hour');
				$table->tinyInteger('activity_price_type')->default(0); // 0 normal , 1 per hour
				$table->integer('activity_price');
				$table->integer('activity_max');
				$table->text('activity_sponsors')->default('[]'); //ARRAY
				$table->string('activity_location_name');
				$table->text('activity_location')->nullable();
				$table->integer('activity_boost_priority')->nullable();
				$table->tinyInteger('activity_allow_comment')->default(0); //0 anyone 1 disciple
				$table->bigInteger('activity_guest_view')->default(0);
				$table->bigInteger('activity_user_view')->default(0);
				$table->bigInteger('activity_user_retention')->default(0);
				$table->timestamps();

				$table->foreign('user_id')->references('user_id')->on('users');
				$table->foreign('category_id')->references('category_id')->on('categories');
				$table->foreign('achievement_id')->references('achievement_id')->on('achievements');
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
