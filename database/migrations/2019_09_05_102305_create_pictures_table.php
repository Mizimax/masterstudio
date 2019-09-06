<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreatePicturesTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('pictures', function (Blueprint $table) {
				$table->bigIncrements('picture_id');
				$table->string('master_id');
				$table->string('picture_url');
				$table->timestamps();

				$table->foreign('user_id')->references('id')->on('users');
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('pictures');
		}
	}
