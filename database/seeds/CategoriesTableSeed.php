<?php

	use Illuminate\Database\Seeder;

	class CategoriesTableSeed extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			DB::table('categories')->insert([
				'category_name' => 'Badminton',
				'category_pic' => '/img/icon/badminton.svg'
			]);
			DB::table('categories')->insert([
				'category_name' => 'Golf',
				'category_pic' => '/img/icon/golf.svg'
			]);
			DB::table('categories')->insert([
				'category_name' => 'Chef',
				'category_pic' => '/img/icon/badminton.svg'
			]);
		}
	}
