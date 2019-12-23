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
				'category_name' => 'Snowboard',
				'category_pic' => '/img/icon/badminton.svg',
				'category_bg' => '/img/Deepsea.jpeg',
				'category_video' => '/video/.mp4'
			]);
			DB::table('categories')->insert([
				'category_name' => 'Chef',
				'category_pic' => '/img/icon/chef.svg',
				'category_bg' => '/img/Deepsea.jpeg',
				'category_video' => '/video/chef.mp4'
			]);
			DB::table('categories')->insert([
				'category_name' => 'Toy maker',
				'category_pic' => '/img/icon/toy.svg',
				'category_bg' => '/img/Deepsea.jpeg',
				'category_video' => '/video/toy.mp4'
			]);
			DB::table('categories')->insert([
				'category_name' => 'Badminton',
				'category_pic' => '/img/icon/badminton.svg',
				'category_bg' => '/img/Deepsea.jpeg',
				'category_video' => '/video/toy.mp4'
			]);
		}
	}
