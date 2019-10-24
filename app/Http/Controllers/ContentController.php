<?php

	namespace App\Http\Controllers;

	use App\Activity;
	use App\ActivityStory;
	use App\UserAchievement;
	use App\UserCategory;
	use Auth;

	class ContentController extends Controller
	{
		//

		/**
		 * Show some activity to grid view.
		 *
		 * @return Illuminate\Http\Response
		 */
		public function activity($offset)
		{

			$limit = 6;
			$queryActivities = Activity::from('activities as act')
				->join('users AS us', 'act.user_id', '=', 'us.user_id')
				->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->skip($offset * $limit)->take($limit)->get();

			if ($queryActivities->isEmpty()) {
				abort(404);
			}
			return view('components.activity-grid-card', ['queryActivities' => $queryActivities]);
		}

		public function timeline($category, $userId)
		{
			$user = Auth::user();
			$timelines = ActivityStory::from('activity_stories as as')
				->join('activities as ac', 'as.activity_id', 'ac.activity_id')
				->join('user_category as uc', 'ac.category_id', 'uc.category_id')
				->join('categories as cg', 'uc.category_id', 'cg.category_id')
				->where('uc.user_id', $userId)
				->where('as.user_id', $userId)
				->where('cg.category_id', $category)->get();
			return view('components.category-timeline', ['timelines' => $timelines, 'user' => $user]);
		}

		public function achievement($category, $userId)
		{
			$achievements = UserAchievement::from('user_achievements as ua')
				->join('achievements as a', 'ua.achievement_id', 'a.achievement_id')
				->where('user_id', $userId)
				->where('ua.category_id', $category)
				->select('a.achievement_pic')
				->get();
			return view('components.achievement', ['achievements' => $achievements]);
		}
	}
