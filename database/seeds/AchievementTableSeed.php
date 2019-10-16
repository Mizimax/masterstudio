<?php

	use Illuminate\Database\Seeder;

	class AchievementTableSeed extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			DB::table('achievements')->insert([
				'achievement_pic' => '/img/icon/badminton.svg',
				'achievement_name' => 'Badminton Badge',
				'achievement_text' => 'You will receive a bandminton badge.',
			]);

		}
	}
