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
				$table->bigInteger('studio_category_id');
				$table->string('studio_name');
				$table->text('studio_description');
				$table->string('studio_location');
				// maps.google.com/?q=lat,long
				// SELECT id, ( 3959 * acos( cos( radians(37) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(-122) ) + sin( radians(37) ) * sin( radians( latitude ) ) ) ) AS distance FROM markers HAVING distance < 25 ORDER BY distance LIMIT 0 , 5;
				$table->int('studio_lat');
				$table->int('studio_long');
				$table->string('studio_pic_action');
				$table->string('studio_bg_action');
				$table->string('studio_video_action');
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
			Schema::dropIfExists('studios');
		}
	}
