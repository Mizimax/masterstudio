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
				$table->string('category_pic');
				$table->string('category_bg');
				$table->string('category_video');
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
