<?php

	use Illuminate\Database\Seeder;

	class PictureTableSeed extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			DB::table('pictures')->insert([
				'picture_action' => 'STUDIO_1_PIC',
				'picture_url' => '/img/profile.jpg'
			]);
			DB::table('pictures')->insert([
				'picture_action' => 'STUDIO_1_PIC',
				'picture_url' => '/img/italian.jpg'
			]);
		}
	}
