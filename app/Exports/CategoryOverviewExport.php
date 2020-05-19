<?php

	namespace App\Exports;

	use App\Activity;
	use App\ActivityStory;
	use App\Category;
	use App\Follow;
	use App\Master;
	use App\Studio;
	use App\User;
	use App\UserActivity;
	use Illuminate\Contracts\View\View;
	use Maatwebsite\Excel\Concerns\FromCollection;
	use Maatwebsite\Excel\Concerns\FromView;
	use Carbon\Carbon;

	class CategoryOverviewExport implements FromView
	{

		public $categoryId;

		public function __construct($categoryId)
		{
			$this->categoryId = $categoryId;
		}

		/**
		 * @return \Illuminate\Support\Collection
		 */
		public function view(): View
		{
			$activityCount = Activity::where('category_id', $this->categoryId)->count();
			$masterCount = Master::where('category_id', $this->categoryId)->count();
			$studioCount = Studio::where('category_id', $this->categoryId)->count();
			$storyCount = ActivityStory::join('activities as act', 'act.activity_id', 'activity_stories.activity_id')
				->where('act.category_id', $this->categoryId)
				->count();
			$userActivityCount = UserActivity::from('user_activities as ua')
				->join('activities as act', 'act.activity_id', 'ua.activity_id')
				->where('act.category_id', $this->categoryId)
				->count();
			$followCount = Follow::join('users', 'follows.following_id', 'users.user_id')
				->join('masters', 'masters.master_id', 'users.master_id')
				->join('categories as cg', 'masters.category_id', 'cg.category_id')
				->where('masters.category_id', $this->categoryId)->count();
			$activity = Activity::where('category_id', $this->categoryId)
				->select(\DB::raw('(activity_hour * activity_price) AS totalIncome'))->first();
			$dt = Carbon::now();
			return view('exports.overview-category', [
				'activityCount' => $activityCount,
				'userActivityCount' => $userActivityCount,
				'storyCount' => $storyCount,
				'followCount' => $followCount,
				'totalIncome' => $activity['totalIncome'],
				'masterCount' => $masterCount,
				'studioCount' => $studioCount,
				'monthYear' => $dt->month . '-' . $dt->year
			]);
		}
	}
