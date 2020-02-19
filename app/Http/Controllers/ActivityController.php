<?php

	namespace App\Http\Controllers;

	use App\Activity;
	use App\ActivityStory;
	use App\ActivityComment;
	use App\UserActivity;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Input;

	class ActivityController extends Controller
	{
		//

		/**
		 * Show all activities page.
		 *
		 * @return Illuminate\Http\Response
		 */
		public function index(Request $request)
		{
			$user = \Auth::user() ? \Auth::user() : ['user_id' => 0];
			$headActivities = Activity::from('activities as act')
				->join('users AS us', 'act.user_id', '=', 'us.user_id')
				->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->select(\DB::raw('*, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user['user_id'] . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 0) AS activity_pin, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user['user_id'] . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 1) AS activity_join'))
				->whereIn('act.activity_id', [1, 2, 3])->get();
			$activities = Activity::from('activities as act')
				->join('users AS us', 'act.user_id', '=', 'us.user_id')
				->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->select(\DB::raw('*, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user['user_id'] . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 0) AS activity_pin, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user['user_id'] . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 1) AS activity_join'))
				->take(6)->get();
			$stories = ActivityStory::from('activity_stories as as')
				->join('activities as ac', 'as.activity_id', 'ac.activity_id')
				->where('as.user_id', $user['user_id'])
				->orderBy('as.activity_story_id', 'desc')
				->get();
			$myActivities = UserActivity::from('user_activities as ua')
				->join('activities as ac', 'ua.activity_id', 'ac.activity_id')
				->where('ua.user_id', $user['user_id'])
				->where('ua.user_activity_paid', 1)->get();
			if ($user['user_id'] === 0) {
				$user = [];
			}
			return view('activity', ['activities' => $activities, 'headActivities' => $headActivities, 'stories' => $stories, 'user' => $user, 'myActivities' => $myActivities]);
		}

		/**
		 * Show a activity page by name parameter.
		 *
		 * @param string $name
		 * @return Illuminate\Http\Response
		 */
		public function show($name)
		{

			$user = \Auth::user() ? \Auth::user() : [];
			$activity = Activity::from('activities as act')
				->join('users AS u', 'u.user_id', '=', 'act.user_id')
				->join('masters AS ms', 'u.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->leftJoin('studios AS st', 'ms.studio_id', '=', 'st.studio_id')
				->join('achievements AS ach', 'act.achievement_id', '=', 'ach.achievement_id')
				->select(\DB::raw('*, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . (!empty($user) ? $user['user_id'] : 0) . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 0) AS activity_pin, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . (!empty($user) ? $user['user_id'] : 0) . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 1) AS activity_join'))
				->where('act.activity_url_name', $name)->first();
			$joinUsers = UserActivity::from('user_activities as ua')
				->join('users AS u', 'u.user_id', '=', 'ua.user_id')
				->where('ua.activity_id', $activity['activity_id'])
				->where('ua.user_activity_paid', 1)->get();
			$activities = Activity::from('activities as act')
				->join('users AS u', 'u.user_id', '=', 'act.user_id')
				->join('masters AS ms', 'u.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')->take(3)->get();
			$stories = ActivityStory::from('activity_stories as as')
				->join('activities as ac', 'as.activity_id', 'ac.activity_id')
				->where('as.activity_id', $activity['activity_id'])
				->where('as.user_id', $activity['user_id'])
				->groupBy('as.activity_id')
				->get();
			$comments = ActivityComment::from('activity_comments as acm')
				->join('activities as ac', 'acm.activity_id', 'ac.activity_id')
				->join('users AS u', 'u.user_id', '=', 'acm.user_id')
				->join('categories AS cg', 'ac.category_id', '=', 'cg.category_id')
				->join('user_category AS uc', 'uc.category_id', '=', 'ac.category_id')
				->groupBy('acm.comment_id')
				->where('ac.activity_url_name', $name)
				->get();
			$cards = \DB::table('payment_card as pc')
				->join('users AS us', 'pc.user_id', '=', 'us.user_id')
				->where('us.user_id', !empty($user) ? $user['user_id'] : 0)->get();
			$isJoined = !!UserActivity::where('user_id', !empty($user) ? $user['user_id'] : 0)
				->where('activity_id', $activity['activity_id'])
				->where('user_activity_paid', 1)
				->first();

			if (empty($activity))
				abort(404);
			return view('activity-detail', ['activity' => $activity, 'activities' => $activities, 'stories' => $stories, 'comments' => $comments, 'user' => $user, 'isJoined' => $isJoined, 'joinUsers' => $joinUsers, 'cards' => $cards]);
		}

		/**
		 * Show a searching activity json.
		 *
		 * @param string $name
		 * @return Illuminate\Http\Response
		 */
		public function search(Request $request)
		{
			$user_id = \Auth::id() ? \Auth::id() : 0;
			$search = $request->query('keyword');
			if (!$search) {
				$search = $request->query('key') ? $request->query('key') : '';
			}
			$activities = Activity::from('activities as act')
				->join('users AS u', 'u.user_id', '=', 'act.user_id')
				->join('masters AS ms', 'u.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->leftJoin('studios AS st', 'ms.studio_id', '=', 'st.studio_id')
				->join('achievements AS ach', 'act.achievement_id', '=', 'ach.achievement_id')
				->select(\DB::raw('*, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user_id . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 0) AS activity_pin, (SELECT COUNT(*) FROM user_activities AS ua WHERE ua.activity_id = act.activity_id AND ua.user_id = ' . $user_id . ' AND ua.user_activity_status = 0 AND ua.user_activity_paid = 1) AS activity_join'))
				->where('act.activity_name', 'LIKE', "%{$search}%")->get();

			if ($request->query('key') || $search === '') {
				return view('components.activity-grid-card', ['activities' => $activities, 'isSearching' => true]);
			}

			return response()->json([
				'status' => 200,
				'data' => $activities,
				'message' => 'Search ' . $search . ' success.'
			], 200);
		}

		/**
		 * Show a searching activity json.
		 *
		 * @param string $name
		 * @return Illuminate\Http\Response
		 */
		public function pin(Request $request, $id)
		{
			UserActivity::create([
				'activity_id' => $id,
				'user_id' => \Auth::id(),
				'user_activity_status' => 0,
				'user_activity_paid' => 0
			]);
			return response()->json([
				'status' => 200,
				'message' => 'Pin activity id : ' . $id . ' success.'
			], 200);
		}

		/**
		 * Show a searching activity json.
		 *
		 * @param string $name
		 * @return Illuminate\Http\Response
		 */
		public function unpin(Request $request, $id)
		{
			UserActivity::where('activity_id', $id)->where('user_id', \Auth::id())->delete();

			return response()->json([
				'status' => 200,
				'message' => 'Unpin activity id : ' . $id . ' success.'
			], 200);
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

		public function comment(Request $request, $id)
		{
			//
			$data = $request->all();
			$indexPic = 0;
			$comment_pic = [];
			while (!empty($data['comment_pic_' . $indexPic]) && $data['comment_pic_' . $indexPic] != 'undefined') {
				$fileName = time() . '.jpg';
				$path = 'img/upload/comment/';
				$request->file('comment_pic_' . $indexPic)->move(public_path($path), $fileName);
				$comment_pic[] = '/' . $path . $fileName;
				$indexPic++;
			}
			ActivityComment::create([
				'activity_id' => $id,
				'user_id' => \Auth::id(),
				'comment_text' => Input::get('comment_text'),
				'comment_rate' => 'normal',
				'comment_pic' => json_encode($comment_pic)
			]);

			return response()->json([
				'status' => 200,
				'message' => 'Added comment'
			], 200);
		}
	}
