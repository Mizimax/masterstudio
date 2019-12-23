<?php

	use Illuminate\Database\Seeder;

	class StudioReview extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			DB::table('studio_reviews')->insert([
				'studio_id' => 1,
				'user_id' => 1,
				'review_text' => '5555'
			]);
		}
	}
