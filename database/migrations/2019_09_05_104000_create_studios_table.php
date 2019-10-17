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
				// maps.google.com/?q=lat,long
				// SELECT id, ( 3959 * acos( cos( radians(37) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(-122) ) + sin( radians(37) ) * sin( radians( latitude ) ) ) ) AS distance FROM markers HAVING distance < 25 ORDER BY distance LIMIT 0 , 5;
				$table->float('studio_lat');
				$table->float('studio_long');
				$table->string('studio_pic'); //Array
				$table->string('studio_bg'); //Array
				$table->string('studio_video'); //Array
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
