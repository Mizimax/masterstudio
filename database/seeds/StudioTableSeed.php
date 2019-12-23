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
				'studio_name' => 'Chef studio',
				'studio_title' => 'Chef title',
				'studio_description' => 'First chef studio in the world',
				'studio_location' => 'https://www.google.com/maps/place/King+Mongkut%E2%80%99s+University+of+Technology+Thonburi/@13.65103,100.4931915,17z/data=!3m1!4b1!4m5!3m4!1s0x30e2a251bb6b0cf1:0xf656e94ff13324ad!8m2!3d13.6510248!4d100.4953802',
				'studio_icon' => '/img/studio/cooking.jpg',
				'studio_lat' => 13.651184,
				'studio_long' => 100.494148,
				'studio_pic' => '["/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg"]',
				'studio_bg' => '["/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg"]',
				'studio_video' => '["/video/chef.mp4"]',
			]);
			DB::table('studios')->insert([
				'category_id' => 2,
				'studio_name' => 'Snowboard studio',
				'studio_title' => 'Snowboard title',
				'studio_description' => 'First snowboard studio in the world',
				'studio_location' => 'https://www.google.com/maps/place/King+Mongkut%E2%80%99s+University+of+Technology+Thonburi/@13.65103,100.4931915,17z/data=!3m1!4b1!4m5!3m4!1s0x30e2a251bb6b0cf1:0xf656e94ff13324ad!8m2!3d13.6510248!4d100.4953802',
				'studio_icon' => '/img/studio/abc.jpg',
				'studio_lat' => 13.745010,
				'studio_long' => 100.534592,
				'studio_pic' => '["/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg"]',
				'studio_bg' => '["/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg"]',
				'studio_video' => '["/video/snowboard.mp4"]',
			]);
			DB::table('studios')->insert([
				'category_id' => 3,
				'studio_name' => 'Toy maker studio',
				'studio_title' => 'Toy maker title',
				'studio_description' => 'First toy maker studio in the world',
				'studio_location' => 'https://www.google.com/maps/place/King+Mongkut%E2%80%99s+University+of+Technology+Thonburi/@13.65103,100.4931915,17z/data=!3m1!4b1!4m5!3m4!1s0x30e2a251bb6b0cf1:0xf656e94ff13324ad!8m2!3d13.6510248!4d100.4953802',
				'studio_icon' => '/img/studio/italian.jpg',
				'studio_lat' => 13.729896,
				'studio_long' => 100.779320,
				'studio_pic' => '["/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg"]',
				'studio_bg' => '["/img/Deepsea.jpeg","/img/Deepsea.jpeg","/img/Deepsea.jpeg"]',
				'studio_video' => '["/video/toy.mp4"]',
			]);
		}
	}
