<?php

	namespace App\Http\Controllers;

	use App\Follow;
	use App\UserActivity;
	use Illuminate\Http\Request;
	use Auth;
	use App\User;

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
			if ($userme['user_id'] == $userId) {
				return redirect('/user/me');
			}
			if ($userId === 'me') {
				$user = $userme;
				$me = true;
			} else {
				$user = User::where('user_id', $userId)->first();
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
	}
