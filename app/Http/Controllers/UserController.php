<?php

	namespace App\Http\Controllers;

	use App\ActivityStory;
	use App\Follow;
	use App\User;
	use App\UserActivity;
	use Auth;
	use Illuminate\Http\Request;

	class UserController extends Controller
	{
		//
		/**
		 * Show current user profile.
		 *
		 * @return Illuminate\Http\Response
		 */
		public function show($userId)
		{

			$isFollower = false;
			$userme = Auth::user();
			if ($userme['user_id'] === $userId) {
				return redirect('/user/me');
			}
			if ($userme['master_id'] === $userId || $userId === 'me') {
				return redirect('/master/me');
			}
			if ($userId === 'me') {
				$user = $userme;
				$me = true;
			} else {
				$user = User::where('user_id', $userId)->first();
				if (!empty($user['master_id'])) {
					return redirect('/master/' . $user['master_id']);
				}
				$me = false;
			}
			if (!$user) {
				return abort(404);
			}
			$follow = Follow::where('following_id', $user['user_id'])
				->where('follower_id', $userme['user_id'])
				->first();
			$isFollower = !!$follow;
			$followers = Follow::where('following_id', $user['user_id'])
				->count();
			$masters = Follow::where('following_id', $user['user_id'])
				->where('follow_type', 'master')
				->count();
			$nowActivities = UserActivity::from('user_activities as ua')
				->join('activities as ac', 'ac.activity_id', 'ua.activity_id')
				->join('users as us', 'us.user_id', 'ac.user_id')
				->join('masters as ms', 'us.master_id', 'ms.master_id')
				->join('categories as cg', 'ac.category_id', 'cg.category_id')
				->where('ua.user_id', $user['user_id'])
				->where('ua.user_activity_status', 0)->get();
			$pastActivities = UserActivity::from('user_activities as ua')
				->join('activities as ac', 'ac.activity_id', 'ua.activity_id')
				->join('users as us', 'us.user_id', 'ac.user_id')
				->join('masters as ms', 'us.master_id', 'ms.master_id')
				->join('categories as cg', 'ac.category_id', 'cg.category_id')
				->where('ua.user_id', $user['user_id'])
				->where('ua.user_activity_status', 1)->get();

			return view('profile', ['user' => $user, 'me' => $me, 'isFollower' => $isFollower, 'followers' => $followers, 'masters' => $masters, 'nowActivities' => $nowActivities, 'pastActivities' => $pastActivities]);
		}

		public function follow($userId)
		{
			$follow = Follow::create(['following_id' => $userId, 'follower_id' => Auth::id(), 'follow_type' => 'user']);
			if (!$follow->exists) {
				return back()->withErrors(['error', "Can't follow this user"]);
			}
			return back();
		}


		protected function more()
		{
			$data = Request::all();
			User::where('user_id', Auth::id())
				->update([
					'user_goal' => $data['user_goal'],
					'user_base_in_th' => $data['user_base_in_th'],
					'user_interest_type' => $data['user_interest_type'],
					'user_prof_rate' => $data['user_prof_rate']
				]);
			return redirect('/');
		}

		protected function story(Request $request, $id)
		{
			$fileName = time() . '.webm';

			$request->file('video-blob')->move(public_path('video/upload'), $fileName);

			ActivityStory::create([
				'activity_id' => $id,
				'user_id' => \Auth::id(),
				'activity_story_video' => '/video/upload/' . $fileName
			]);

			return response()->json([
				'status' => 200,
				'message' => 'Upload success.'
			], 200);
		}
	}
