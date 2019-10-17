<?php

	use Illuminate\Database\Seeder;

	class DatabaseSeeder extends Seeder
	{
		/**
		 * Seed the application's database.
		 *
		 * @return void
		 */
		public function run()
		{
			$this->call([CategoriesTableSeed::class, MasterTableSeed::class, UserTableSeed::class, StudioTableSeed::class, AchievementTableSeed::class, ActivityTableSeed::class, BenefitTableSeed::class, ActivityStoryTableSeed::class, UserActivityTableSeed::class, FollowTableSeed::class, ExpTableSeed::class, ActivityCommentTableSeed::class, UserAchievementTableSeed::class, UserCategoryTableSeed::class]);

		}
	}
