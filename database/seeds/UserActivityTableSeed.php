<?php

	use Illuminate\Database\Seeder;

	class UserActivityTableSeed extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			DB::table('user_activities')->insert([
				'activity_id' => 1,
				'user_id' => 1,
				'user_activity_status' => 0
			]);
		}
	}
