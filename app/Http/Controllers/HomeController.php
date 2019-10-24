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
			$headActivities = Activity::from('activities as act')
				->join('users AS us', 'act.user_id', '=', 'us.user_id')
				->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->whereIn('act.activity_id', [1, 2, 3])->get();
			$activities = Activity::from('activities as act')
				->join('users AS us', 'act.user_id', '=', 'us.user_id')
				->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')->take(6)->get();
			$stories = ActivityStory::from('activity_stories as as')
				->join('activities as act', 'as.activity_id', 'act.activity_id')
				->join('users AS us', 'act.user_id', '=', 'us.user_id')
				->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->select('*', 'as.created_at AS story_created_at')
				->get();
			return view('home', ['headActivities' => $headActivities, 'activities' => $activities, 'stories' => $stories]);
		}
	}
