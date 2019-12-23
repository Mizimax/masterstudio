<?php

	use Illuminate\Database\Seeder;

	class FollowTableSeed extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			DB::table('follows')->insert([
				'following_id' => 1,
				'follower_id' => 1
			]);
			DB::table('follows')->insert([
				'following_id' => 2,
				'follower_id' => 2
			]);
			DB::table('follows')->insert([
				'following_id' => 3,
				'follower_id' => 3
			]);
			DB::table('follows')->insert([
				'following_id' => 4,
				'follower_id' => 4
			]);
			DB::table('follows')->insert([
				'following_id' => 5,
				'follower_id' => 5
			]);
			DB::table('follows')->insert([
				'following_id' => 6,
				'follower_id' => 6
			]);
			DB::table('follows')->insert([
				'following_id' => 9,
				'follower_id' => 9
			]);
			DB::table('follows')->insert([
				'following_id' => 10,
				'follower_id' => 10
			]);
			DB::table('follows')->insert([
				'following_id' => 11,
				'follower_id' => 11
			]);
			DB::table('follows')->insert([
				'following_id' => 12,
				'follower_id' => 12
			]);
		}
	}
