<?php

	namespace App\Http\Controllers;

	use App\Activity;
	use App\ActivityStory;
	use App\Follow;
	use App\Master;
	use App\UserAchievement;
	use App\UserActivity;
	use Auth;
	use Illuminate\Http\Request;

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

		/**
		 * Show some activity to grid view.
		 *
		 * @return Illuminate\Http\Response
		 */
		public function activities(Request $request)
		{
			$user_id = \Auth::id() ? \Auth::id() : 0;
			$category_id = $request->query('category');
			$category_id = json_decode($category_id, true);
			if (!is_array($category_id)) {
				$category_id = [$category_id];
			}
			if (empty($category_id)) {
				$queryActivities = Activity::from('activities as act')
					->join('users AS us', 'act.user_id', '=', 'us.user_id')
					->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
					->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
					->select(\DB::raw('*, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user_id . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 0) AS activity_pin, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user_id . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 1) AS activity_join'))
					->take(6)->get();
			} else {
				$queryActivities = Activity::from('activities as act')
					->join('users AS us', 'act.user_id', '=', 'us.user_id')
					->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
					->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
					->select(\DB::raw('*, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user_id . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 0) AS activity_pin, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user_id . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 1) AS activity_join'))
					->whereIn('act.category_id', $category_id)
					->get();
			}

			if ($queryActivities->isEmpty()) {
				abort(404);
			}
			return view('components.activity-grid-card', ['queryActivities' => $queryActivities, 'isSearching' => true]);
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
			if ($timelines->isEmpty())
				return response()->view('components.category-timeline', ['timelines' => $timelines, 'user' => $user], 404);
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
			if ($achievements->isEmpty())
				return response()->view('components.achievement', ['achievements' => $achievements], 404);
			return view('components.achievement', ['achievements' => $achievements]);
		}

		public function map()
		{
			$studios = Follow::from('follows AS fl')
				->join('studios AS st', 'st.studio_id', '=', 'fl.studio_id')
				->where('fl.follower_id', Auth::id())
				->where('fl.follow_type', 'studio')
				->get();

			if ($studios->isEmpty()) {
				return response('No followed studio.');
			}

			return view('components.map', ['studios' => $studios]);
		}

		public function allActivity()
		{
			$user_id = Auth::id();
			$nowActivities = UserActivity::from('user_activities as ua')
				->join('activities as ac', 'ac.activity_id', 'ua.activity_id')
				->join('users as us', 'us.user_id', 'ac.user_id')
				->join('masters as ms', 'us.master_id', 'ms.master_id')
				->join('categories as cg', 'ac.category_id', 'cg.category_id')
				->where('ua.user_id', $user_id)
				->where('ua.user_activity_status', 0)
				->orderBy('ua.user_activity_id', 'desc')->get();
			$pastActivities = UserActivity::from('user_activities as ua')
				->join('activities as ac', 'ac.activity_id', 'ua.activity_id')
				->join('users as us', 'us.user_id', 'ac.user_id')
				->join('masters as ms', 'us.master_id', 'ms.master_id')
				->join('categories as cg', 'ac.category_id', 'cg.category_id')
				->where('ua.user_id', $user_id)
				->where('ua.user_activity_paid', 1)
				->where('ua.user_activity_status', 1)->get();

			return view('components.all-activity', ['nowActivities' => $nowActivities, 'pastActivities' => $pastActivities]);
		}

		public function follow()
		{
			$userme = Auth::user() ? Auth::user() : ['user_id' => 0];
			$masters = Follow::from('follows AS fl')
				->join('users AS us', 'fl.following_id', '=', 'us.user_id')
				->join('activities AS act', 'act.user_id', '=', 'fl.following_id')
				->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->where('fl.follower_id', Auth::id())
				->where('fl.follow_type', 'master')
				->groupBy('following_id')
				->select(\DB::raw('ms.*, us.user_pic, cg.category_name, act.activity_video, act.activity_url_name, (SELECT COUNT(*) FROM follows AS fls WHERE fls.following_id = ms.master_id) AS master_follower'))
				->get();

			return view('components.master-list', ['masters' => $masters, 'userme' => $userme, 'noFollow' => 'true']);
		}

		public function studioMaster($studio_id)
		{
			$masters = Master::join('users as us', 'us.master_id', '=', 'masters.master_id')
				->where('masters.studio_id', $studio_id)->get();

			return view('components.master-map', ['masters' => $masters]);
		}

	}
