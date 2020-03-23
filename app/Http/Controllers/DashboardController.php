<?php

	namespace App\Http\Controllers;

	use App\Achievement;
	use App\Activity;
	use App\ActivityStory;
	use App\Category;
	use App\Master;
	use App\Studio;
	use App\User;
	use Illuminate\Http\Request;

	class DashboardController extends Controller
	{
		//

		public function index()
		{
			if (\Auth::user()->user_type != 'admin') {
				return redirect('/dashboard/master');
			}
			return redirect('/dashboard/user');
		}

		public function masters()
		{
			if (\Auth::user()->user_type != 'admin') {
				return redirect('/dashboard/master/' . \Auth::user()->master_id);
			}
			$masters = Master::join('users', 'users.master_id', 'masters.master_id')->get();
			return view('dashboard-master', ['masters' => $masters]);
		}

		public function master($masterId)
		{
			$master = Master::join('users', 'users.master_id', 'masters.master_id')
				->where('masters.master_id', $masterId)->first();
			$categories = Category::get();
			return view('dashboard-master-id', ['master' => $master, 'categories' => $categories]);
		}

		public function addMaster()
		{
			$categories = Category::get();
			return view('dashboard-master-create', ['categories' => $categories]);
		}

		public function createMaster(Request $request)
		{
			$this->validate($request, [
				'user_email' => 'required|email|unique:users'
			]);
			$inputs = $request->input();
			$files = $request->file();

			if ($inputs['user_password'] != $inputs['confirm_user_password']) {
				return redirect()->back()->withErrors(['message' => 'Password must be equal.']);
			}

			$user = [
				'user_name' => $inputs['user_name'],
				'user_email' => $inputs['user_email'],
				'user_password' => $inputs['user_password'],
			];

			if (isset($files['user_pic'])) {
				$path = '/img/upload/user/';
				$fileName = time() . '.jpg';
				$files['user_pic']->move(public_path($path), $fileName);
				$user['user_pic'] = $path . $fileName;
			}

			User::create($user);

			Master::create([
				'master_name' => $inputs['master_name'],
				'category_id' => $inputs['category_id'],
				'master_nickname' => $inputs['master_nickname'],
				'master_location' => $inputs['master_location'],
				'master_recommended' => $inputs['master_recommended'] == 1 ? 1 : 0,
				'master_most_recommended' => $inputs['master_recommended'] == 2 ? 1 : 0,
			]);
			return redirect()->back();
		}

		public function editMaster(Request $request, $masterId)
		{
			$inputs = $request->input();
			$files = $request->file();

			if ($inputs['user_password'] != $inputs['confirm_user_password']) {
				return redirect()->back()->withErrors(['message' => 'Password must be equal.']);
			}

			$user = [
				'user_name' => $inputs['user_name'],
				'user_email' => $inputs['user_email'],
				'user_password' => $inputs['user_password'],
			];

			if (isset($files['user_pic'])) {
				$path = '/img/upload/user/';
				$fileName = time() . '.jpg';
				$files['user_pic']->move(public_path($path), $fileName);
				$user['user_pic'] = $path . $fileName;
			}

			User::where('master_id', $masterId)->update($user);

			Master::where('master_id', $masterId)->update([
				'master_name' => $inputs['master_name'],
				'category_id' => $inputs['category_id'],
				'master_nickname' => $inputs['master_nickname'],
				'master_location' => $inputs['master_location'],
				'master_recommended' => $inputs['master_recommended'] == 1 ? 1 : 0,
				'master_most_recommended' => $inputs['master_recommended'] == 2 ? 1 : 0,
			]);
			return redirect()->back();
		}

		public function removeMaster($masterId)
		{
			Master::where('master_id', $masterId)->delete();
			return redirect()->back();
		}


		public function studios()
		{
			$user = \Auth::user();
			if ($user->user_type != 'admin') {
				$studioId = Studio::where('studios.studio_user', $user->user_id)->first();
				if ($studioId) {
					return redirect('/dashboard/studio/' . $studioId['studio_id']);
				}
				return view('dashboard-studio', ['studios' => [], 'nostudio' => true]);
			}
			$studios = Studio::join('categories as cg', 'cg.category_id', 'studios.category_id')->get();
			return view('dashboard-studio', ['studios' => $studios]);
		}

		public function studio($studioId)
		{
			$user = \Auth::user();
			$studios = Studio::where('studios.studio_id', $studioId)
				->join('users as us', 'us.user_id', 'studios.studio_user')
				->join('masters as ms', 'ms.master_id', 'us.master_id')
				->first();
			if ($user->user_type != 'admin' && $studios['studio_user'] != $user['user_id']) {
				return redirect('/dashboard/studio');
			}
			$studios['studio_bg'] = json_decode($studios['studio_bg'], true);
			$studios['studio_video'] = json_decode($studios['studio_video'], true);

			$categories = Category::get();
			$masters = Master::get();
			return view('dashboard-studio-id', ['studios' => $studios, 'categories' => $categories, 'masters' => $masters]);
		}

		public function addStudio()
		{
			$user = \Auth::user();

			if ($user->user_type != 'admin') {
				return redirect('/dashboard/studio');
			}
			$categories = Category::get();
			return view('dashboard-studio-create', ['categories' => $categories]);
		}

		public function createStudio(Request $request)
		{
			$inputs = $request->input();
			$files = $request->file();
			$user = \Auth::user();

			if ($user->user_type != 'admin') {
				return redirect('/dashboard/studio');
			}

			$path = '/img/upload/studio/';
			$studioData = [];
			$studioData['studio_icon'] = '';
			$studioData['studio_bg'] = [];
			$studioData['studio_video'] = [];

			foreach ($files as $name => $file) {
				if ($name != 'studio_icon') {
					foreach ($file as $i => $f) {
						$fileName = time() . ($name == 'studio_video' ? '.mp4' : '.jpg');
						$f->move(public_path($path), $fileName);
						$studioData[$name][$i] = $path . $fileName;
					}
				} else {
					$fileName = time() . '.jpg';
					$file->move(public_path($path), $fileName);
					$studioData[$name] = $path . $fileName;
				}
			}

			Studio::create([
				'studio_name' => $inputs['studio_name'],
				'studio_title' => $inputs['studio_title'],
				'category_id' => $inputs['category_id'],
				'studio_description' => $inputs['studio_description'],
				'studio_location' => $inputs['studio_location'],
				'studio_icon' => $studioData['studio_icon'],
				'studio_bg' => json_encode($studioData['studio_bg']),
				'studio_video' => json_encode($studioData['studio_video']),
			]);
			return redirect()->back();
		}

		public function editStudio(Request $request, $studioId)
		{
			$inputs = $request->input();
			$files = $request->file();
			$user = \Auth::user();

			$studioModel = Studio::where('studios.studio_id', $studioId);
			$studio = $studioModel->first();
			if ($user->user_type != 'admin' && $studio['studio_user'] != $user['user_id']) {
				return redirect('/dashboard/studio');
			}

			$path = '/img/upload/studio/';
			$studioData = [];
			$studioData['studio_icon'] = $studio['studio_icon'];
			$studioData['studio_bg'] = json_decode($studio['studio_bg'], true);
			$studioData['studio_video'] = json_decode($studio['studio_video'], true);

			foreach ($files as $name => $file) {
				if ($name != 'studio_icon') {
					foreach ($file as $i => $f) {
						$fileName = time() . ($name == 'studio_video' ? '.mp4' : '.jpg');
						$f->move(public_path($path), $fileName);
						$studioData[$name][$i] = $path . $fileName;
					}
				} else {
					$fileName = time() . '.jpg';
					$file->move(public_path($path), $fileName);
					$studioData[$name] = $path . $fileName;
				}
			}

			$studioModel->update([
				'studio_name' => $inputs['studio_name'],
				'studio_title' => $inputs['studio_title'],
				'category_id' => $inputs['category_id'],
				'studio_description' => $inputs['studio_description'],
				'studio_location' => $inputs['studio_location'],
				'studio_icon' => $studioData['studio_icon'],
				'master_id' => $studioData['master_id'],
				'studio_bg' => json_encode($studioData['studio_bg']),
				'studio_video' => json_encode($studioData['studio_video']),
			]);
			return redirect()->back();
		}

		public function removeStudio($studioId)
		{
			Studio::where('studios.studio_id', $studioId)->delete();
			return redirect()->back();
		}

		public function users()
		{
			$users = User::get();
			return view('dashboard-user', ['users' => $users]);
		}

		public function user($userId)
		{
			$user = User::where('user_id', $userId)->get();
			return view('dashboard-user-id', ['user' => $user]);
		}

		public function editUser(Request $request, $userId)
		{
			$inputs = $request->input();
			$files = $request->file();

			if ($inputs['user_password'] != $inputs['confirm_user_password']) {
				return redirect()->back()->withErrors(['message' => 'Password must be equal.']);
			}

			$user = [
				'user_name' => $inputs['user_name'],
				'user_email' => $inputs['user_email'],
				'user_password' => $inputs['user_password'],
			];

			if (isset($files['user_pic'])) {
				$path = '/img/upload/user/';
				$fileName = time() . '.jpg';
				$files['user_pic']->move(public_path($path), $fileName);
				$user['user_pic'] = $path . $fileName;
			}

			User::where('user_id', $userId)->update($user);
			return redirect()->back();
		}

		public function addUser()
		{

		}

		public function createUser(Request $request, $userId)
		{
			$inputs = $request->input();
			$files = $request->file();

			if ($inputs['user_password'] != $inputs['confirm_user_password']) {
				return redirect()->back()->withErrors(['message' => 'Password must be equal.']);
			}

			$user = [
				'user_name' => $inputs['user_name'],
				'user_email' => $inputs['user_email'],
				'user_password' => $inputs['user_password'],
			];

			if (isset($files['user_pic'])) {
				$path = '/img/upload/user/';
				$fileName = time() . '.jpg';
				$files['user_pic']->move(public_path($path), $fileName);
				$user['user_pic'] = $path . $fileName;
			}

			User::where('user_id', $userId)->update($user);
			return redirect()->back();
		}


		public function removeUser($userId)
		{

			User::where('user_id', $userId)->update();
			return redirect()->back();
		}

		public function activities()
		{
			$activities = Activity::join('users as u', 'u.user_id', 'activities.user_id')
				->join('masters as m', 'm.master_id', 'u.master_id')->get();
			return view('dashboard-activity', ['activities' => $activities]);
		}

		public function activity($activityId)
		{
			$activity = Activity::join('users as u', 'u.user_id', 'activities.user_id')
				->join('masters as m', 'm.master_id', 'u.master_id')
				->where('activities.activity_id', $activityId)
				->first();
			$activity['activity_video'] = json_decode($activity['activity_video'], true);
			$activity['activity_pic'] = json_decode($activity['activity_pic'], true);
			$activity['activity_benefit'] = json_decode($activity['activity_benefit'], true);
			$activity['activity_sponsors'] = json_decode($activity['activity_sponsors'], true);

			$categories = Category::get();
			$achievement = Achievement::get();
			return view('dashboard-activity-id', ['activity' => $activity, 'categories' => $categories, 'achievement' => $achievement]);
		}

		public function editActivity(Request $request, $activityId)
		{
			$inputs = $request->input();
			$files = $request->file();

			$activityModel = Activity::where('activities.activity_id', $activityId);
			$activity = $activityModel->first();

			$path = '/img/upload/activity/';
			$activityData = [];
			$activityData['activity_sponsor'] = json_decode($activity['activity_sponsors'], true);
			$activityData['activity_benefit'] = json_decode($activity['activity_benefit'], true);
			$activityData['activity_video'] = json_decode($activity['activity_video'], true);
			$activityData['activity_pic'] = json_decode($activity['activity_pic'], true);
			foreach ($files as $name => $file) {
				foreach ($file as $i => $f) {
					if ($name === 'activity_video' || $name === 'activity_pic') {
						$fileName = time() . ($name == 'activity_video' ? '.mp4' : '.jpg');
						$f->move(public_path($path), $fileName);
						$activityData[$name][$i] = $path . $fileName;
					} else {
						$fileName = time() . '.jpg';
						$f->move(public_path($path), $fileName);
						if ($name !== 'sponsor_pic') {
							$activityData['activity_benefit'][$i][($name == 'bg' ? 'bg' : 'pic')] = $path . $fileName;
						} else {
							$activityData['activity_sponsor'][$i]['url'] = $path . $fileName;
						}
					}
				}
			}

			foreach ($inputs['benefit_name'] as $i => $bf) {
				$activityData['activity_benefit'][$i]['name'] = $bf;
				$activityData['activity_benefit'][$i]['text'] = $inputs['benefit_desc'][$i];
			}

			foreach ($inputs['sponsor_name'] as $i => $sp) {
				$activityData['activity_sponsor'][$i]['name'] = $sp;
				$activityData['activity_sponsor'][$i]['link'] = $inputs['sponsor_link'][$i];
			}

			$activityModel->update([
				'activity_name' => $inputs['activity_name'],
				'activity_url_name' => $inputs['activity_url_name'],
				'category_id' => $inputs['category_id'],
				'achievement_id' => $inputs['achievement_id'],
				'activity_description' => $inputs['activity_description'],
				'activity_location' => $inputs['activity_location'],
				'activity_location_name' => $inputs['activity_location_name'],
				'activity_prepare' => $inputs['activity_prepare'],
				'activity_difficult' => $inputs['activity_difficult'],
				'activity_time_type' => $inputs['activity_time_type'],
				'activity_apply_start' => $inputs['activity_apply_start'],
				'activity_apply_end' => $inputs['activity_apply_end'],
				'activity_start' => $inputs['activity_start'],
				'activity_end' => $inputs['activity_end'],
				'activity_routine_day' => $inputs['activity_routine_day'],
				'activity_time_start' => $inputs['activity_time_start'],
				'activity_time_end' => $inputs['activity_time_end'],
				'activity_price' => $inputs['activity_price'],
				'activity_price_type' => $inputs['activity_price_type'],
				'activity_hour' => $inputs['activity_hour'],
				'activity_max' => $inputs['activity_max'],
				'activity_time_end' => $inputs['activity_time_end'],
				'activity_sponsors' => json_encode($activityData['activity_sponsor']),
				'activity_benefit' => json_encode($activityData['activity_benefit']),
				'activity_video' => json_encode($activityData['activity_video']),
				'activity_pic' => json_encode($activityData['activity_pic']),
			]);
			return redirect()->back();
		}

		public function stories()
		{
			$stories = ActivityStory::from('activity_stories as as')
				->join('activities as act', 'act.activity_id', '=', 'as.activity_id')
				->get();
			return view('dashboard-story', ['stories' => $stories]);
		}

		public function removeStory($storyId)
		{
			ActivityStory::where('activity_story_id', $storyId)->delete();
			return redirect()->back();
		}

	}
