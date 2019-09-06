<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateMastersTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('masters', function (Blueprint $table) {
				$table->bigIncrements('master_id');
				$table->string('master_name');
				$table->string('master_nickname');
				$table->date('master_birth');
				$table->string('master_activity_name');
				$table->string('master_activity_pic_id');
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
			Schema::dropIfExists('masters');
		}
	}
