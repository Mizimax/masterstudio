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
			DB::table('user_category')->insert([
				'category_id' => 1,
				'user_id' => 1
			]);
			DB::table('user_category')->insert([
				'category_id' => 1,
				'user_id' => 1
			]);
			DB::table('user_category')->insert([
				'category_id' => 1,
				'user_id' => 1
			]);
		}
	}
