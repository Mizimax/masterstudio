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
			if ($userme['user_id'] == $userId) {
				return redirect('/user/me');
			}
			if ($userme['master_id'] == $userId || ($userId == 'me' && $userme['master_id'])) {
				return redirect('/master/me');
			}
			if ($userId == 'me') {
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
			$masters = Follow::join('users as u', 'u.user_id', 'follows.following_id')
				->join('masters as m', 'm.master_id', 'u.master_id')
				->where('follower_id', $userme['user_id'])
				->where('follow_type', 'master')
				->get();
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


		protected function more(Request $request)
		{
			$data = $request->all();
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
			$type = $request->query('type');

			if ($type !== 'lesson') {
				$type = 'story';
			}

			$fileName = time() . '.webm';

			$request->file('video-blob')->move(public_path('video/upload'), $fileName);

			ActivityStory::create([
				'activity_id' => $id,
				'user_id' => \Auth::id(),
				'activity_story_video' => '/video/upload/' . $fileName,
				'story_status' => $type
			]);

			return response()->json([
				'status' => 200,
				'message' => 'Upload success.'
			], 200);
		}

		public function editProfile(Request $request, $user_id, $action)
		{
			$editProfile = 0;

			if ($action == 'delete') {
				$path = '/img/';
				$fileName = 'profile.jpg';
				$editProfile = User::where('user_id', $user_id)->update([
					'user_pic' => '/img/profile.jpg',
				]);
			} else {
				$path = '/img/upload/profile/';
				$fileName = time() . '.jpg';
				$request->file('image')->move(public_path($path), $fileName);
				$editProfile = User::where('user_id', $user_id)->update([
					'user_pic' => $path . $fileName,
				]);
			}

			if ($editProfile === 0) {
				return response()->json([
					'status' => 400,
					'message' => "Can't edit profile picture"
				], 400);
			}

			return response()->json([
				'status' => 200,
				'image_url' => $path . $fileName,
				'message' => 'Edit profile success.'
			], 200);
		}

		/**
		 * Update gallery image.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function delGallery(Request $request, $id, $picId)
		{
			if (\Auth::id() == $id) {
				$galleries = User::where('user_id', $id)->select('user_gallery')->first();
				$galleries = json_decode($galleries['user_gallery'], true);
				array_splice($galleries, $picId, 1);
				User::where('user_id', $id)
					->update([
						'user_gallery' => json_encode($galleries)
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
			if (\Auth::id() == $id) {
				$path = '/img/upload/user/' . $id . '/gallery/';
				$fileName = time() . '.jpg';
				$request->file('image')->move(public_path($path), $fileName);
				$galleries = User::where('user_id', $id)->select('user_gallery')->first();
				$userGallery = json_decode($galleries['user_gallery'], true);
				$userGallery[] = $path . $fileName;
				User::where('user_id', $id)
					->update([
						'user_gallery' => json_encode($userGallery)
					]);
				$userGallery = array_reverse($userGallery);
			} else {
				return response()->json([
					'status' => 401,
					'message' => 'Unauthorized.'
				], 401);
			}
			return view('components.gallery', ['galleries' => $userGallery, 'me' => true]);
		}

		public function getLogout()
		{
			Auth::logout();

			return redirect()->back();
		}


	}
