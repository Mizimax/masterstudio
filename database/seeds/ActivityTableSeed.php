<?php

	use Illuminate\Database\Seeder;
	use Carbon\Carbon;

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
			$now = Carbon::now();
			$apply_end = $now->addDays(15);
			$start = $now->addDays(20);
			$end = $now->addDays(22);
			$routine = $now->addDays(25)->dayOfWeek + 1;
			DB::table('activities')->insert([
				'studio_id' => 1,
				'master_id' => 1,
				'category_id' => 2,
				'achievement_id' => 1,
				'activity_video' => '["/video/video1.mp4"]',
				'activity_name' => 'Badminton Challenge',
				'activity_url_name' => 'badminton-challenge',
				'activity_description' => 'Badminton Challenge',
				'activity_benefit' => '[{"pic":"/img/profile.jpg","bg":"/img/Deepsea.jpg","name":"Benefit 1","text":"Benefit 1 description"},{"pic":"/img/profile.jpg","bg":"/img/Deepsea.jpg","name":"Benefit 1","text":"Benefit 1 description"},{"pic":"/img/profile.jpg","bg":"/img/Deepsea.jpg","name":"Benefit 1","text":"Benefit 1 description"}]',
				'activity_prepare' => '<ul><li>eiei</li></ul>',
				'activity_difficult' => 'Middle',
				'activity_time_type' => 0,
				'activity_apply_start' => $now,
				'activity_apply_end' => $apply_end,
				'activity_start' => $start,
				'activity_end' => $end,
				'activity_routine_day' => $routine,
				'activity_time_start' => '10:00',
				'activity_time_end' => '22:00',
				'activity_hour' => 16,
				'activity_price' => 3000,
				'activity_max' => 20,
				'activity_location_name' => 'BMT',
			]);
			DB::table('activities')->insert([
				'studio_id' => 1,
				'master_id' => 1,
				'category_id' => 3,
				'achievement_id' => 1,
				'activity_video' => '["/video/video1.mp4"]',
				'activity_name' => 'Badminton Challenge',
				'activity_url_name' => 'badminton-challenge2',
				'activity_description' => 'Badminton Challenge',
				'activity_benefit' => '[{"pic":"/img/profile.jpg","bg":"/img/Deepsea.jpg","name":"Benefit 1","text":"Benefit 1 description"},{"pic":"/img/profile.jpg","bg":"/img/Deepsea.jpg","name":"Benefit 1","text":"Benefit 1 description"},{"pic":"/img/profile.jpg","bg":"/img/Deepsea.jpg","name":"Benefit 1","text":"Benefit 1 description"}]',
				'activity_prepare' => '<ul><li>eiei</li></ul>',
				'activity_difficult' => 'Middle',
				'activity_time_type' => 0,
				'activity_apply_start' => $now,
				'activity_apply_end' => $apply_end,
				'activity_start' => $start,
				'activity_end' => $end,
				'activity_routine_day' => $routine,
				'activity_time_start' => '10:00',
				'activity_time_end' => '22:00',
				'activity_hour' => 16,
				'activity_price' => 3000,
				'activity_max' => 20,
				'activity_location_name' => 'BMT',
			]);
			DB::table('activities')->insert([
				'studio_id' => 1,
				'master_id' => 1,
				'category_id' => 1,
				'achievement_id' => 1,
				'activity_video' => '["/video/video1.mp4"]',
				'activity_name' => 'Badminton Challenge',
				'activity_url_name' => 'badminton-challenge3',
				'activity_description' => 'Badminton Challenge',
				'activity_benefit' => '[{"pic":"/img/profile.jpg","bg":"/img/Deepsea.jpg","name":"Benefit 1","text":"Benefit 1 description"},{"pic":"/img/profile.jpg","bg":"/img/Deepsea.jpg","name":"Benefit 1","text":"Benefit 1 description"},{"pic":"/img/profile.jpg","bg":"/img/Deepsea.jpg","name":"Benefit 1","text":"Benefit 1 description"}]',
				'activity_prepare' => '<ul><li>eiei</li></ul>',
				'activity_difficult' => 'Middle',
				'activity_time_type' => 0,
				'activity_apply_start' => $now,
				'activity_apply_end' => $apply_end,
				'activity_start' => $start,
				'activity_end' => $end,
				'activity_routine_day' => $routine,
				'activity_time_start' => '10:00',
				'activity_time_end' => '22:00',
				'activity_hour' => 16,
				'activity_price' => 3000,
				'activity_max' => 20,
				'activity_location_name' => 'BMT',
			]);
		}
	}
