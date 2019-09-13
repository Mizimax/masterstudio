<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateActivitiesBenefitTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('activity_benefits', function (Blueprint $table) {
				$table->bigIncrements('activity_benefit_id');
				$table->string('activity_benefit_name');
				$table->string('activity_benefit_pic');
				$table->string('activity_benefit_bg');
				$table->string('activity_benefit_bullet');
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
			Schema::dropIfExists('activities_benefit');
		}
	}
