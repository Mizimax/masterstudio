<?php

	namespace App\Exports;

	use App\Activity;
	use App\Category;
	use App\Follow;
	use App\Master;
	use App\User;
	use App\UserActivity;
	use Illuminate\Contracts\View\View;
	use Maatwebsite\Excel\Concerns\FromView;
	use Carbon\Carbon;

	class OverviewExport implements FromView
	{
		/**
		 * @return \Illuminate\Support\Collection
		 */
		public function view(): View
		{
			$allActivityCount = Activity::count();
			$allMasterCount = Master::count();
			$allUserCount = User::count();
			$allUserActivityCount = UserActivity::count();
			$allFollowCount = Follow::where('follow_type', 'studio')->count();
			$allActivity = Activity::select(\DB::raw('(activity_hour * activity_price) AS totalIncome'))->first();
			$categories = Category::get();
			$dt = Carbon::now();
			$result = [
				'allActivityCount' => $allActivityCount,
				'allMasterCount' => $allMasterCount,
				'allUserActivityCount' => $allUserActivityCount,
				'allUserCount' => $allUserCount,
				'allFollowCount' => $allFollowCount,
				'totalIncome' => $allActivity['totalIncome'],
				'categories' => $categories,
				'monthYear' => $dt->month . '-' . $dt->year
			];
			return view('exports.overview', $result);
		}
	}
