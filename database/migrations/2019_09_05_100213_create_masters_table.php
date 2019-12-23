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
				$table->bigInteger('category_id')->unsigned();
				$table->bigInteger('studio_id')->unsigned()->nullable();
				$table->string('master_name');
				$table->string('master_nickname');
				$table->text('master_background')->default('[]'); //Array
				$table->date('master_birth');
				$table->string('master_activity_name');
				$table->text('master_activity_pic')->default('[]'); //Array
				$table->text('master_activity_describe');
				$table->string('master_talent');
				$table->string('master_phone');
				$table->text('master_objective');
				$table->tinyInteger('master_recommend')->default(0); //0 = no, 1 = basic, 2 = ] advance
				$table->tinyInteger('master_most_recommend')->default(0); //0 = no, 1 = basic, 2 = advance
				$table->integer('master_disciple')->default(0);
				$table->integer('master_mastered')->default(0);
				$table->bigInteger('master_guest_view')->default(0);
				$table->bigInteger('master_user_view')->default(0);
				$table->bigInteger('master_user_retention')->default(0);
				$table->timestamps();

				$table->foreign('category_id')->references('category_id')->on('categories');
				$table->foreign('studio_id')->references('studio_id')->on('studios');
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
