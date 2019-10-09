<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateBenefitsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{

			Schema::create('benefits', function (Blueprint $table) {
				$table->bigIncrements('benefit_id');
				$table->bigInteger('activity_id')->unsigned();
				$table->string('benefit_name');
				$table->string('benefit_pic');
				$table->string('benefit_bg');
				$table->text('benefit_bullet');
				$table->timestamps();

				$table->foreign('activity_id')->references('activity_id')->on('activities');

			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('benefits');
		}
	}
