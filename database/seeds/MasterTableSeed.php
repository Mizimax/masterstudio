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
				'master_name' => 'MasterName',
				'master_nickname' => 'MasterMax',
				'master_background_action' => 'MASTER_1_BG',
				'master_birth' => date("Y-m-d H:i:s"),
				'master_activity_name' => 'Badminton challenge',
				'master_activity_pic_action' => 'MASTER_1_ACT_PIC',
				'master_activity_describe' => 'Challenge badminton',
				'master_talent' => 'NO.1 in master challenge',
				'master_phone' => '0847440744',
				'master_objective' => 'To get more disciple'
			]);

		}
	}