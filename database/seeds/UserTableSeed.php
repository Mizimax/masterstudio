<?php

	use Illuminate\Database\Seeder;
	use Illuminate\Support\Facades\Hash;

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
				'user_email' => 'maxza1@admin.in.th',
				'user_password' => Hash::make('0847440744'),
				'user_birth' => date("Y-m-d H:i:s"),
			]);

			DB::table('users')->insert([
				'master_id' => 2,
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza2@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'master_id' => 3,
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza3@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'master_id' => 4,
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza4@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'master_id' => 5,
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza5@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'master_id' => 6,
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza6@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'master_id' => 7,
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza7@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'master_id' => 8,
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza8@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza9@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza10@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza11@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza12@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza13@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza14@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza15@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza16@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza17@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza18@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza19@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza20@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);

			DB::table('users')->insert([
				'user_name' => 'Tammanoon Jomjaturong',
				'user_email' => 'maxza21@admin.in.th',
				'user_password' => Hash::make('0847440744'),
			]);
		}
	}
