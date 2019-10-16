<?php

	use Illuminate\Database\Seeder;

	class UserTableSeed extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			DB::table('users')->insert([
				'master_id' => 1,
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza@admin.in.th',
				'user_password' => 'hash64'
			]);
		}
	}
