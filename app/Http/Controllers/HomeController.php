<?php

	namespace App\Http\Controllers;

	use App\Activity;
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
				->join('masters AS ms', 'act.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->whereIn('act.activity_id', [1, 2, 3])->get();
			$activities = Activity::from('activities as act')
				->join('masters AS ms', 'act.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')->take(6)->get();
			return view('home', ['headActivities' => $headActivities, 'activities' => $activities]);
		}
	}
