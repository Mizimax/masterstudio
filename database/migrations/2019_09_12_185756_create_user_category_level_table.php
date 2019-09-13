<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateUserCategoryLevelTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('user_category_level', function (Blueprint $table) {
				$table->bigIncrements('user_category_level_id');
				$table->bigInteger('category_id');
				$table->bigInteger('user_id');
				$table->bigInteger('user_level')->default(1);
				$table->bigInteger('user_exp')->default(0);
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
			Schema::dropIfExists('user_category_level');
		}
	}
