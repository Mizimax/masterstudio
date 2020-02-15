<?php

	namespace App\Http\Controllers;

	use App\Activity;
	use App\ActivityStory;
	use Carbon\Carbon;

	class HomeController extends Controller
	{
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

		/**
		 * Show the application dashboard.
		 *
		 * @return \Illuminate\Contracts\Support\Renderable
		 */
		public function index()
		{
			$user_id = \Auth::id() ? \Auth::id() : 0;
			$headActivities = Activity::from('activities as act')
				->join('users AS us', 'act.user_id', '=', 'us.user_id')
				->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->select(\DB::raw('*, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user_id . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 0) AS activity_pin, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user_id . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 1) AS activity_join'))
				->whereIn('act.activity_id', [1, 2, 3])->orderBy('activity_id')->get();
			$activities = Activity::from('activities as act')
				->join('users AS us', 'act.user_id', '=', 'us.user_id')
				->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->select(\DB::raw('*, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user_id . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 0) AS activity_pin, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user_id . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 1) AS activity_join'))
				->take(6)->orderBy('activity_id')->get();
			$stories = ActivityStory::from('activity_stories as as')
				->join('activities as act', 'as.activity_id', 'act.activity_id')
				->join('users AS us', 'act.user_id', '=', 'us.user_id')
				->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'ms.category_id', '=', 'cg.category_id')
				->select('*', 'as.created_at AS story_created_at')
				->where('as.story_highlight', 1)
				->get();
			return view('home', ['headActivities' => $headActivities, 'activities' => $activities, 'stories' => $stories]);
		}
	}
