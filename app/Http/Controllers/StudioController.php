<?php

	namespace App\Http\Controllers;

	use App\Activity;
	use App\ActivityStory;
	use App\Follow;
	use App\Master;
	use App\Studio;
	use App\StudioReview;
	use App\User;
	use Illuminate\Http\Request;

	class StudioController extends Controller
	{
		/**
		 * Show all studios page.
		 *
		 * @return Illuminate\Http\Response
		 */
		public function index()
		{
			$studio = Studio::get();
			return view('studio', ['studios' => $studio]);
		}

		/**
		 * Show a studio page by name parameter.
		 *
		 * @param string $name
		 * @return Illuminate\Http\Response
		 */
		public function show($id)
		{
			$studio = Studio::where('studio_id', $id)->first();
			if (!$studio) {
				return abort(404);
			}
			$studio['studio_pic'] = json_decode($studio['studio_pic'], true);
			$studio['studio_bg'] = json_decode($studio['studio_bg'], true);
			$studio['studio_video'] = json_decode($studio['studio_video'], true);
			$activities = Activity::from('activities as act')
				->join('users AS u', 'u.user_id', '=', 'act.user_id')
				->join('masters AS ms', 'u.master_id', '=', 'ms.master_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->where('ms.studio_id', $id)->take(4)->get();
			$stories = ActivityStory::from('activity_stories as as')
				->join('activities as act', 'act.activity_id', '=', 'as.activity_id')
				->join('users as us', 'us.user_id', '=', 'as.user_id')
				->join('masters as ms', 'us.master_id', '=', 'ms.master_id')
				->where('ms.studio_id', $id)->get();
			$reviews = StudioReview::from('studio_reviews as sr')
				->join('users as us', 'us.user_id', '=', 'sr.user_id')
				->where('sr.studio_id', $id)
				->orderBy('review_id', 'desc')->get();
			$userid = \Auth::id() ? \Auth::id() : '0';
			$masters = User::from('users AS us')
				->join('masters AS ms', 'ms.master_id', '=', 'us.master_id')
				->join('activities AS act', 'act.user_id', '=', 'us.user_id')
				->join('categories AS cg', 'act.category_id', '=', 'cg.category_id')
				->groupBy('us.user_id')
				->where('ms.studio_id', $id)
				->select(\DB::raw('ms.*, us.user_pic, cg.category_name, act.activity_video, act.activity_url_name, (SELECT COUNT(*) FROM follows AS fls WHERE fls.following_id = ms.master_id) AS master_follower, (SELECT COUNT(*) FROM follows AS flss WHERE flss.following_id = ms.master_id and flss.follower_id = ' . $userid . ') AS isFollow'))
				->get();
			$follow = Follow::where('studio_id', $id)
				->where('follower_id', \Auth::id())
				->first();
			$isFollower = !!$follow;
			return view('studio-detail', ['studio' => $studio, 'activities' => $activities, 'stories' => $stories, 'reviews' => $reviews, 'masters' => $masters, 'isFollower' => $isFollower]);
		}

		/**
		 * Show the form for creating a new studio.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
			//
		}

		/**
		 * Store a new studio.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			//
		}

		/**
		 * Show the form for editing a studio.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
			//
		}

		/**
		 * Update a studio.
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
		 * Remove a studio.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
			//
		}

		/**
		 * Update review studio.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function review(Request $request, $id)
		{
			//
			StudioReview::create([
				'studio_id' => $id,
				'user_id' => \Auth::id(),
				'review_text' => $request->input('review_text')
			]);

			return response()->json([
				'status' => 200,
				'message' => 'Added review'
			], 200);
		}

		public function follow($id)
		{
			$studio_id = (int)$id;
			$follow = Follow::create(['studio_id' => $studio_id, 'follower_id' => \Auth::id(), 'follow_type' => 'studio']);
			if (!$follow->exists) {
				return back()->withErrors(['error', "Can't follow this studio"]);
			}
			return back();
		}
	}
