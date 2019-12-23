<?php

	use Illuminate\Database\Seeder;

	class MasterTableSeed extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			DB::table('masters')->insert([
				'category_id' => 1,
				'master_name' => 'Jang wonyong',
				'master_nickname' => 'Jang',
				'master_background' => '["/img/bg.jpg"]',
				'master_birth' => date("Y-m-d H:i:s"),
				'master_activity_name' => 'Badminton challenge',
				'master_activity_pic' => '["/img/activity/1.jpg"]',
				'master_activity_describe' => 'Challenge badminton',
				'master_talent' => 'NO.1 in master challenge',
				'master_phone' => '0847440744',
				'master_objective' => 'To get more disciple'
			]);

			DB::table('masters')->insert([
				'category_id' => 2,
				'master_name' => 'Tammanoon Max',
				'master_nickname' => 'Jang',
				'master_background' => '["/img/bg.jpg"]',
				'master_birth' => date("Y-m-d H:i:s"),
				'master_activity_name' => 'Badminton challenge',
				'master_activity_pic' => '["/img/activity/1.jpg"]',
				'master_activity_describe' => 'Challenge badminton',
				'master_talent' => 'NO.1 in master challenge',
				'master_phone' => '0847440744',
				'master_objective' => 'To get more disciple'
			]);

			DB::table('masters')->insert([
				'category_id' => 3,
				'master_name' => 'Sou Pachee',
				'master_nickname' => 'Jang',
				'master_background' => '["/img/bg.jpg"]',
				'master_birth' => date("Y-m-d H:i:s"),
				'master_activity_name' => 'Badminton challenge',
				'master_activity_pic' => '["/img/activity/1.jpg"]',
				'master_activity_describe' => 'Challenge badminton',
				'master_talent' => 'NO.1 in master challenge',
				'master_phone' => '0847440744',
				'master_objective' => 'To get more disciple'
			]);

			DB::table('masters')->insert([
				'category_id' => 1,
				'master_name' => 'Sithisak Angthong',
				'master_nickname' => 'Jang',
				'master_background' => '["/img/bg.jpg"]',
				'master_birth' => date("Y-m-d H:i:s"),
				'master_activity_name' => 'Badminton challenge',
				'master_activity_pic' => '["/img/activity/1.jpg"]',
				'master_activity_describe' => 'Challenge badminton',
				'master_talent' => 'NO.1 in master challenge',
				'master_phone' => '0847440744',
				'master_objective' => 'To get more disciple'
			]);

			DB::table('masters')->insert([
				'category_id' => 2,
				'master_name' => 'Good Master',
				'master_nickname' => 'Jang',
				'master_background' => '["/img/bg.jpg"]',
				'master_birth' => date("Y-m-d H:i:s"),
				'master_activity_name' => 'Badminton challenge',
				'master_activity_pic' => '["/img/activity/1.jpg"]',
				'master_activity_describe' => 'Challenge badminton',
				'master_talent' => 'NO.1 in master challenge',
				'master_phone' => '0847440744',
				'master_objective' => 'To get more disciple'
			]);

			DB::table('masters')->insert([
				'category_id' => 3,
				'master_name' => 'Wai longdi',
				'master_nickname' => 'Jang',
				'master_background' => '["/img/bg.jpg"]',
				'master_birth' => date("Y-m-d H:i:s"),
				'master_activity_name' => 'Badminton challenge',
				'master_activity_pic' => '["/img/activity/1.jpg"]',
				'master_activity_describe' => 'Challenge badminton',
				'master_talent' => 'NO.1 in master challenge',
				'master_phone' => '0847440744',
				'master_objective' => 'To get more disciple'
			]);

			DB::table('masters')->insert([
				'category_id' => 1,
				'master_name' => 'Pai Naidee',
				'master_nickname' => 'Jang',
				'master_background' => '["/img/bg.jpg"]',
				'master_birth' => date("Y-m-d H:i:s"),
				'master_activity_name' => 'Badminton challenge',
				'master_activity_pic' => '["/img/activity/1.jpg"]',
				'master_activity_describe' => 'Challenge badminton',
				'master_talent' => 'NO.1 in master challenge',
				'master_phone' => '0847440744',
				'master_objective' => 'To get more disciple'
			]);

			DB::table('masters')->insert([
				'category_id' => 2,
				'master_name' => 'Su Sever',
				'master_nickname' => 'Jang',
				'master_background' => '["/img/bg.jpg"]',
				'master_birth' => date("Y-m-d H:i:s"),
				'master_activity_name' => 'Badminton challenge',
				'master_activity_pic' => '["/img/activity/1.jpg"]',
				'master_activity_describe' => 'Challenge badminton',
				'master_talent' => 'NO.1 in master challenge',
				'master_phone' => '0847440744',
				'master_objective' => 'To get more disciple'
			]);

		}
	}