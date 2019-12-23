<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateCategoriesTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{

			Schema::create('categories', function (Blueprint $table) {
				$table->bigIncrements('category_id');
				$table->string('category_name');
				$table->text('category_pic');
				// category bg video for background show
				$table->text('category_bg')->default('/img/category/default.jpg');
				$table->text('category_video')->nullable();
				$table->integer('category_exp')->default(1500);
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
			Schema::dropIfExists('categories');
		}
	}
