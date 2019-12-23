<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateStudiosTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{

			Schema::create('studios', function (Blueprint $table) {
				$table->bigIncrements('studio_id');
				$table->bigInteger('category_id')->unsigned();
				$table->string('studio_name')->unique();
				$table->string('studio_title');
				$table->text('studio_description');
				$table->text('studio_location');
				$table->text('studio_icon');
				// maps.google.com/?q=lat,long
				// SELECT id, ( 3959 * acos( cos( radians(37) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(-122) ) + sin( radians(37) ) * sin( radians( latitude ) ) ) ) AS distance FROM markers HAVING distance < 25 ORDER BY distance LIMIT 0 , 5;
				$table->double('studio_lat', 12, 6);
				$table->double('studio_long', 12, 6);
				$table->text('studio_pic')->default('[]'); //Array
				$table->text('studio_bg')->default('[]'); //Array
				$table->text('studio_video')->default('[]'); //Array
				$table->timestamps();

				$table->foreign('category_id')->references('category_id')->on('categories');

			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('studios');
		}
	}
