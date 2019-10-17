<?php

	use Illuminate\Database\Seeder;

	class StudioTableSeed extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			DB::table('studios')->insert([
				'category_id' => 1,
				'studio_name' => 'First studio',
				'studio_description' => 'First studio in the world',
				'studio_location' => 'https://www.google.com/maps/place/King+Mongkut%E2%80%99s+University+of+Technology+Thonburi/@13.65103,100.4931915,17z/data=!3m1!4b1!4m5!3m4!1s0x30e2a251bb6b0cf1:0xf656e94ff13324ad!8m2!3d13.6510248!4d100.4953802',
				'studio_lat' => 13.651184,
				'studio_long' => 100.494148,
				'studio_pic' => '["/img/eiei.jpg"]',
				'studio_bg' => '["/img/eiei.jpg"]',
				'studio_video' => '["/img/eiei.jpg"]',
			]);
		}
	}
