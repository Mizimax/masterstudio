<?php

	use Illuminate\Database\Seeder;

	class UserCategoryTableSeed extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			DB::table('user_categories')->insert([
				'category_id' => 1,
				'user_id' => 1
			]);
			DB::table('user_categories')->insert([
				'category_name' => 2,
				'category_pic' => 1
			]);
			DB::table('user_categories')->insert([
				'category_name' => 3,
				'category_pic' => 1
			]);
		}
	}
