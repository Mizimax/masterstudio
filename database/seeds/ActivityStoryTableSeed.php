<?php

	use Illuminate\Database\Seeder;

	class ActivityStoryTableSeed extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			DB::table('activity_stories')->insert([
				'activity_id' => 1,
				'user_id' => 1,
				'activity_story_video' => 'https://maxang.me/activity.mp4'
			]);
			DB::table('activity_stories')->insert([
				'activity_id' => 1,
				'user_id' => 2,
				'activity_story_video' => 'https://maxang.me/activity.mp4'
			]);
			DB::table('activity_stories')->insert([
				'activity_id' => 2,
				'user_id' => 3,
				'activity_story_video' => 'https://maxang.me/activity.mp4'
			]);
			DB::table('activity_stories')->insert([
				'activity_id' => 3,
				'user_id' => 4,
				'activity_story_video' => 'https://maxang.me/activity.mp4'
			]);
			DB::table('activity_stories')->insert([
				'activity_id' => 2,
				'user_id' => 1,
				'activity_story_video' => 'https://maxang.me/activity.mp4'
			]);
			DB::table('activity_stories')->insert([
				'activity_id' => 1,
				'user_id' => 2,
				'activity_story_video' => 'https://maxang.me/activity.mp4'
			]);
			DB::table('activity_stories')->insert([
				'activity_id' => 2,
				'user_id' => 3,
				'activity_story_video' => 'https://maxang.me/activity.mp4'
			]);
			DB::table('activity_stories')->insert([
				'activity_id' => 3,
				'user_id' => 4,
				'activity_story_video' => 'https://maxang.me/activity.mp4'
			]);
		}
	}
