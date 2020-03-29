<?php

	namespace App\Http\Controllers;

	use App\Activity;
	use App\ActivityStory;
	use App\Follow;
	use App\Master;
	use App\User;
	use Auth;
	use Carbon\Carbon;
	use Illuminate\Http\Request;

	class MasterController extends Controller
	{
		//
		/**
		 * Show all masters page.
		 *
		 * @return Illuminate\Http\Response
		 */
		public function index()
		{
			$userme = Auth::user() ? Auth::user() : ['user_id' => 0];
			$master1 = Master::join('categories as cg', 'cg.category_id', '=', 'masters.category_id')
				->join('users', 'users.master_id', '=', 'masters.master_id')
				->where('masters.category_id', 4)
				->where(function ($query) {
					$query->where('masters.master_recommend', '!=', 0)
						->orWhere('masters.master_most_recommend', '!=', 0);

				})
				->select(\DB::raw('*, (SELECT COUNT(*) FROM follows AS fls WHERE fls.following_id = masters.master_id) AS master_follower, (SELECT COUNT(*) FROM follows WHERE follower_id = ' . $userme['user_id'] . ' AND following_id = users.user_id) AS follower'))
				->take(2)->get();
			$master2 = Master::join('categories as cg', 'cg.category_id', '=', 'masters.category_id')
				->join('users', 'users.master_id', '=', 'masters.master_id')
				->where('masters.category_id', 2)
				->where(function ($query) {
					$query->where('masters.master_recommend', '!=', 0)
						->orWhere('masters.master_most_recommend', '!=', 0);

				})
				->select(\DB::raw('*, (SELECT COUNT(*) FROM follows AS fls WHERE fls.following_id = masters.master_id) AS master_follower, (SELECT COUNT(*) FROM follows WHERE follower_id = ' . $userme['user_id'] . ' AND following_id = users.user_id) AS follower'))
				->take(2)->get();
			$master3 = Master::join('categories as cg', 'cg.category_id', '=', 'masters.category_id')
				->join('users', 'users.master_id', '=', 'masters.master_id')
				->where('masters.category_id', 3)
				->where(function ($query) {
					$query->where('masters.master_recommend', '!=', 0)
						->orWhere('masters.master_most_recommend', '!=', 0);

				})
				->select(\DB::raw('*, (SELECT COUNT(*) FROM follows AS fls WHERE fls.following_id = masters.master_id) AS master_follower, (SELECT COUNT(*) FROM follows WHERE follower_id = ' . $userme['user_id'] . ' AND following_id = users.user_id) AS follower'))
				->take(2)->get();

			$allMasters = User::from('users AS us')
				->join('masters AS ms', 'ms.master_id', '=', 'us.master_id')
				->join('activities AS act', 'act.user_id', '=', 'us.user_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->groupBy('us.user_id')
				->select(\DB::raw('ms.*, us.user_id, us.user_pic, cg.category_name, act.activity_video, act.activity_url_name, (SELECT COUNT(*) FROM follows AS fls WHERE fls.following_id = ms.master_id) AS master_follower, (SELECT COUNT(*) FROM follows WHERE follower_id = ' . $userme['user_id'] . ' AND following_id = us.user_id) AS follower'))
				->get();

			return view('master', ['masters' => [$master1, $master2, $master3], 'allMasters' => $allMasters, 'userme' => $userme]);
		}

		/**
		 * Show a master page by name parameter.
		 *
		 * @param string $name
		 * @return Illuminate\Http\Response
		 */
		public function show($id)
		{
			$userme = Auth::user();
			if ($id == $userme['master_id']) {
				return redirect('/master/me');
			}
			if ($id === 'me') {
				$id = $userme['master_id'];
				$me = true;
			} else {
				$me = false;
			}
			$master = Master::join('users as us', 'us.master_id', '=', 'masters.master_id')
				->join('categories as cg', 'cg.category_id', '=', 'masters.category_id')
				->leftJoin('studios as st', 'st.studio_id', '=', 'masters.studio_id')
				->where('masters.master_id', $id)
				->select(\DB::raw('*, (SELECT COUNT(*) FROM follows AS fls WHERE fls.following_id = masters.master_id) AS master_follower'))
				->first();
			if (!$master) {
				return abort(404);
			}
			$master['master_activity_pic'] = json_decode($master['master_activity_pic'], true);
			$master['master_activity_pic'] = array_reverse($master['master_activity_pic']);
			$follow = Follow::where('following_id', $master['user_id'])
				->where('follower_id', $userme['user_id'])
				->first();
			$isFollower = !!$follow;
			$stories = ActivityStory::from('activity_stories as as')
				->join('activities as act', 'act.activity_id', '=', 'as.activity_id')
				->join('users as us', 'us.user_id', '=', 'as.user_id')
				->join('masters as ms', 'us.master_id', '=', 'ms.master_id')
				->where('ms.master_id', $id)->get();
			$nowActivities = Activity::from('activities as act')
				->join('users AS us', 'act.user_id', '=', 'us.user_id')
				->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->where('ms.master_id', $id)
				->where('act.activity_apply_end', '>=', Carbon::now())->get();
			$pastActivities = Activity::from('activities as act')
				->join('users AS us', 'act.user_id', '=', 'us.user_id')
				->join('masters AS ms', 'us.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->where('ms.master_id', $id)
				->where('act.activity_apply_end', '<', Carbon::now())->get();
			return view('master-detail', ['nowActivities' => $nowActivities, 'pastActivities' => $pastActivities, 'stories' => $stories, 'master' => $master, 'me' => $me, 'isFollower' => $isFollower]);
		}

		public function follow($userId)
		{
			$userId = (int)$userId;
			$master = Master::join('users as us', 'us.master_id', '=', 'masters.master_id')
				->select('us.user_id')
				->where('masters.master_id', $userId)->first();
			$follow = Follow::create(['following_id' => $master['user_id'], 'follower_id' => Auth::id(), 'follow_type' => 'master']);
			if (!$follow->exists) {
				return back()->withErrors(['error', "Can't follow this master"]);
			}
			return back();
		}

		/**
		 * Show searching activity html.
		 *
		 * @param string $name
		 * @return Illuminate\Http\Response
		 */
		public function search(Request $request)
		{
			$userme = Auth::user() ? Auth::user() : ['user_id' => 0];
			$search = $request->query('keyword');
			$masters = User::from('users AS us')
				->join('masters AS ms', 'ms.master_id', '=', 'us.master_id')
				->join('activities AS act', 'act.user_id', '=', 'us.user_id')
				->join('categories AS cg', 'ms.category_id', '=', 'cg.category_id')
				->groupBy('us.user_id')
				->select(\DB::raw('ms.*, us.user_pic, cg.category_name, act.activity_video, act.activity_url_name, (SELECT COUNT(*) FROM follows AS fls WHERE fls.following_id = ms.master_id) AS master_follower'))
				->where('ms.master_name', 'LIKE', "%{$search}%")->get();

			return view('components.master-list', ['masters' => $masters, 'userme' => $userme]);
		}

		/**
		 * Show a searching activity html.
		 *
		 * @param string $name
		 * @return Illuminate\Http\Response
		 */
		public function category(Request $request)
		{
			$category_id = $request->query('category');
			$category_id = json_decode($category_id, true);
			if (!is_array($category_id)) {
				$category_id = [$category_id];
			}
			if (count($category_id) !== 0) {
				$masters = User::from('users AS us')
					->join('masters AS ms', 'ms.master_id', '=', 'us.master_id')
					->join('activities AS act', 'act.user_id', '=', 'us.user_id')
					->join('categories AS cg', 'ms.category_id', '=', 'cg.category_id')
					->groupBy('us.user_id')
					->select(\DB::raw('ms.*, us.user_pic, cg.category_name, act.activity_video, act.activity_url_name, (SELECT COUNT(*) FROM follows AS fls WHERE fls.following_id = ms.master_id) AS master_follower'))
					->whereIn('ms.category_id', $category_id)->get();
			} else {
				$masters = User::from('users AS us')
					->join('masters AS ms', 'ms.master_id', '=', 'us.master_id')
					->join('activities AS act', 'act.user_id', '=', 'us.user_id')
					->join('categories AS cg', 'ms.category_id', '=', 'cg.category_id')
					->groupBy('us.user_id')
					->select(\DB::raw('ms.*, us.user_pic, cg.category_name, act.activity_video, act.activity_url_name, (SELECT COUNT(*) FROM follows AS fls WHERE fls.following_id = ms.master_id) AS master_follower'))
					->get();
			}
			$userme = Auth::user() ? Auth::user() : ['user_id' => 0];

			return view('components.master-list', ['masters' => $masters, 'userme' => $userme]);
		}

		/**
		 * Update gallery image.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function delGallery(Request $request, $id, $picId)
		{
			if (\Auth::user()->master_id == $id) {
				$galleries = Master::where('master_id', $id)->select('master_activity_pic')->first();
				$galleries = json_decode($galleries['master_activity_pic'], true);
				array_splice($galleries, $picId, 1);
				Master::where('master_id', $id)
					->update([
						'master_activity_pic' => json_encode($galleries)
					]);

				$galleries = array_reverse($galleries);

			} else {
				return response()->json([
					'status' => 401,
					'message' => 'Unauthorized.'
				], 401);
			}
			return view('components.gallery', ['galleries' => $galleries, 'me' => true]);
		}

		/**
		 * Update gallery image.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function addGallery(Request $request, $id)
		{
			if (\Auth::user()->master_id == $id) {
				$path = '/img/upload/master/' . $id . '/gallery/';
				$fileName = time() . '.jpg';
				$request->file('image')->move(public_path($path), $fileName);
				$galleries = Master::where('master_id', $id)->select('master_activity_pic')->first();
				$masterGallery = json_decode($galleries['master_activity_pic'], true);
				$masterGallery[] = $path . $fileName;
				Master::where('master_id', $id)
					->update([
						'master_activity_pic' => json_encode($masterGallery)
					]);
				$masterGallery = array_reverse($masterGallery);
			} else {
				return response()->json([
					'status' => 401,
					'message' => 'Unauthorized.'
				], 401);
			}
			return view('components.gallery', ['galleries' => $masterGallery, 'me' => true]);

		}

		/**
		 * Show the form for creating a new master.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create(Request $request)
		{
			//
			$fileName = [];
			$path = '/img/upload/become/';
			$i = 0;

			$becomes = [
				'pro_desc' => $request->input('pro_desc'),
				'phone_number' => $request->input('pro_desc'),
				'email_contact' => $request->input('email_contact'),
				'goal' => $request->input('goal'),
			];

			foreach ($request->file() as $name => $file) {
				$fileName[$i] = time() . '.jpg';
				$request->file($name)->move(public_path($path), $fileName[$i]);
				$becomes[$name] = $path . $fileName[$i++];
			}

			\DB::table('becomes')->insert($becomes);
			return redirect()->back()->with(['message' => 'Master request success']);
		}

		/**
		 * Store a new master.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			//
		}

		/**
		 * Show the form for editing a master.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
			//
		}

		/**
		 * Update a master.
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
		 * Remove a master.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
			//
		}
	}
