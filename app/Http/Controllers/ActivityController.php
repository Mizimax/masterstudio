<?php

	namespace App\Http\Controllers;

	use App\Activity;
	use Illuminate\Http\Request;

	class ActivityController extends Controller
	{
		//

		/**
		 * Show all activities page.
		 *
		 * @return Illuminate\Http\Response
		 */
		public function index()
		{
			$activities = Activity::from('activities as act')
				->join('users AS us', 'act.user_id', '=', 'us.user_id')
				->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')->take(6)->get();
			return view('activity', ['activities' => $activities]);
		}

		/**
		 * Show a activity page by name parameter.
		 *
		 * @param string $name
		 * @return Illuminate\Http\Response
		 */
		public function show($name)
		{
			$activity = Activity::from('activities as act')
				->join('masters AS ms', 'act.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->join('studios AS st', 'act.studio_id', '=', 'st.studio_id')
				->join('achievements AS ach', 'act.achievement_id', '=', 'ach.achievement_id')
				->where('act.activity_url_name', $name)->first();
			$activities = Activity::from('activities as act')
				->join('masters AS ms', 'act.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')->take(3)->get();
			if (empty($activity))
				abort(404);
			return view('activity-detail', ['activity' => $activity, 'activities' => $activities]);
		}

		/**
		 * Show the form for creating a new activity.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
			//
		}

		/**
		 * Store a new activity.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			//
		}

		/**
		 * Show the form for editing a activity.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
			//
		}

		/**
		 * Update a activity.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, $id)
		{
			//
		}

		/**
		 * Remove a activity.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
			//
		}
	}
