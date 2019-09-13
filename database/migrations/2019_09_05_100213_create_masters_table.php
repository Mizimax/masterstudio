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
				$table->string('master_background_action');
				$table->date('master_birth');
				$table->string('master_activity_name');
				$table->string('master_activity_pic_action');
				$table->text('master_activity_describe');
				$table->string('master_talent');
				$table->string('master_phone');
				$table->string('master_objective');
				$table->text('master_objective');
				$table->bigInteger('master_guest_view')->default(0);
				$table->bigInteger('master_user_view')->default(0);
				$table->bigInteger('master_user_retention')->default(0);
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
