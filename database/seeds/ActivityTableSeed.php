<?php

	use Illuminate\Database\Seeder;

	class ActivityTableSeed extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			DB::table('activities')->insert([
				'studio_id' => 1,
				'master_id' => 1,
				'category_id' => 1,
				'achievement_id' => 1,
				'activity_video_action' => 'ACTIVITY_1_VIDEO',
				'activity_name' => 'Badminton Challenge',
				'activity_url_name' => 'badminton-challenge',
				'activity_description' => 'Badminton Challenge',
				'activity_prepare' => '<ul><li>eiei</li></ul>',
				'activity_difficult' => 'Middle',
				'activity_apply_start' => '',
				'activity_apply_end' => '',
				''
			]);
		}
	}
