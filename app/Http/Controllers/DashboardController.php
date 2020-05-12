<?php

	namespace App\Http\Controllers;

	use App\Achievement;
	use App\Activity;
	use App\ActivityStory;
	use App\Category;
	use App\Exports\OverviewExport;
	use App\Exports\CategoryOverviewExport;
	use App\Mail\WebSubscription;
	use App\Master;
	use App\Studio;
	use App\Subscriber;
	use App\User;
	use App\Follow;
	use App\UserActivity;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Mail;
	use Illuminate\Support\Facades\Validator;
	use Maatwebsite\Excel\Facades\Excel;
	use Carbon\Carbon;

	class DashboardController extends Controller
	{
		//

		public function index()
		{
			if (\Auth::check() && \Auth::user()->user_type != 'admin') {
				return redirect('/dashboard/master');
			}
			$allActivityCount = Activity::count();
			$allMasterCount = Master::count();
			$allUserCount = User::count();
			$allUserActivityCount = UserActivity::count();
			$allFollowCount = Follow::where('follow_type', 'studio')->count();
			$allActivity = Activity::select(\DB::raw('(activity_hour * activity_price) AS totalIncome'))->first();
			$categories = Category::get();
			return view('dashboard-index', [
				'allActivityCount' => $allActivityCount,
				'allMasterCount' => $allMasterCount,
				'allUserActivityCount' => $allUserActivityCount,
				'allUserCount' => $allUserCount,
				'allFollowCount' => $allFollowCount,
				'totalIncome' => $allActivity['totalIncome'],
				'categories' => $categories,

			]);
		}

		public function export()
		{
			$dt = Carbon::now();
			return Excel::download(new OverviewExport(), 'atmaster_overview_' . $dt->toDateString() . '.xlsx');
		}

		public function exportCategory($categoryId)
		{
			$dt = Carbon::now();
			return Excel::download(new CategoryOverviewExport($categoryId), 'atmaster_' . $categoryId . '_overview_' . $dt->toDateString() . '.xlsx');
		}

		public function getCategoryInfo($categoryId)
		{
			$activityCount = Activity::where('category_id', $categoryId)->count();
			$masterCount = Master::where('category_id', $categoryId)->count();
			$studioCount = Studio::where('category_id', $categoryId)->count();
			$storyCount = ActivityStory::join('activities as act', 'act.activity_id', 'activity_stories.activity_id')
				->where('act.category_id', $categoryId)
				->count();
			$userActivityCount = UserActivity::from('user_activities as ua')
				->join('activities as act', 'act.activity_id', 'ua.activity_id')
				->where('act.category_id', $categoryId)
				->count();
			$followCount = Follow::join('users', 'follows.following_id', 'users.user_id')
				->join('masters', 'masters.master_id', 'users.master_id')
				->join('categories as cg', 'masters.category_id', 'cg.category_id')
				->where('masters.category_id', $categoryId)->count();
			$activity = Activity::where('category_id', $categoryId)
				->select(\DB::raw('(activity_hour * activity_price) AS totalIncome'))->first();
			return view('dashboard-category-info', [
				'activityCount' => $activityCount,
				'userActivityCount' => $userActivityCount,
				'storyCount' => $storyCount,
				'followCount' => $followCount,
				'totalIncome' => $activity['totalIncome'],
				'masterCount' => $masterCount,
				'studioCount' => $studioCount,
			]);
		}

		public function login()
		{
			if (\Auth::check()) {
				return redirect('/dashboard');
			}
			return view('dashboard');
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
			$users = User::get();
			return view('dashboard-master-create', ['categories' => $categories, 'users' => $users]);
		}

		public function createMaster(Request $request)
		{
			$inputs = $request->input();
			$files = $request->file();

			$masterId = Master::create([
				'master_name' => $inputs['master_name'],
				'category_id' => $inputs['category_id'],
				'master_nickname' => $inputs['master_nickname'],
				'master_location' => $inputs['master_location'],
				'master_recommend' => $inputs['master_recommend'] == 1 ? 1 : 0,
				'master_most_recommend' => $inputs['master_recommend'] == 2 ? 1 : 0,
			])->id;

			if (!isset($inputs['user_id'])) {
				$validator = Validator::make($request->all(), [
					'user_email' => 'required|email|unique:users',
				]);
				if ($validator->fails()) {
					return redirect()->back()->withErrors($validator)->withInput();
				}
				if ($inputs['user_password'] != $inputs['confirm_user_password']) {
					return redirect()->back()->withErrors(['message' => 'Password must be equal.'])->withInput();
				}

				$user = [
					'user_name' => $inputs['user_name'],
					'user_email' => $inputs['user_email'],
					'user_password' => $inputs['user_password'],
					'master_id' => $masterId
				];

				if (isset($files['user_pic'])) {
					$path = '/img/upload/user/';
					$fileName = time() . '.jpg';
					$files['user_pic']->move(public_path($path), $fileName);
					$user['user_pic'] = $path . $fileName;
				}

				User::create($user);
			} else {
				User::where('user_id', $inputs['user_id'])->update([
					'master_id' => $masterId
				]);
			}

			return redirect()->back()->with('success', 'Create master data success !');
		}

		public function editMaster(Request $request, $masterId)
		{
			$inputs = $request->input();
			$files = $request->file();
			if ($inputs['user_email']) {
				$validator = Validator::make($request->all(), [
					'user_email' => 'required|email|unique:users',
				]);
				if ($validator->fails()) {
					return redirect()->back()->withErrors($validator)->withInput();
				}
			}

			if ($inputs['user_password'] != $inputs['confirm_user_password']) {
				return redirect()->back()->withErrors(['message' => 'Password must be equal.'])->withInput();
			}

			$user = [
				'user_name' => $inputs['user_name'],
				'user_password' => $inputs['user_password'],
			];

			if ($inputs['user_email']) {
				$user['user_email'] = $inputs['user_email'];
			}

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
				'master_recommend' => $inputs['master_recommend'] == 1 ? 1 : 0,
				'master_most_recommend' => $inputs['master_recommend'] == 2 ? 1 : 0,
			]);
			return redirect()->back()->with('success', 'Edit user data success !');
		}

		public function removeMaster($masterId)
		{
			Master::where('master_id', $masterId)->delete();
			return redirect()->back();
		}

		public function removeActivity($activityId)
		{
			$user = \Auth::user();
			$activityModel = Activity::where('activity_id', $activityId);
			$activity = $activityModel->first();
			if ($user['user_type'] != 'admin') {
				if ($activity['user_id'] !== $user['user_id']) {
					return redirect()->back();
				}
			}
			$activityModel->delete();
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
				->select('*', 'studios.studio_id', 'studios.studio_video')
				->first();
			if ($user->user_type != 'admin' && $studios['studio_user'] != $user['user_id']) {
				return redirect('/dashboard/studio');
			}

			$studios['studio_bg'] = json_decode($studios['studio_bg'], true);
			$studios['studio_video'] = json_decode($studios['studio_video'], true);

			$joinMasters = Master::join('users', 'users.master_id', 'masters.master_id')->where('studio_id', $studioId)->get();
			$categories = Category::get();
			$masters = Master::join('users', 'users.master_id', 'masters.master_id')->where('masters.studio_id', '!=', $studioId)
				->orWhere('masters.studio_id', null)->get();
			return view('dashboard-studio-id', ['studios' => $studios, 'categories' => $categories, 'masters' => $masters, 'joinMasters' => $joinMasters]);
		}

		public function addMasterStudio(Request $request, $studioId, $masterId)
		{
			Master::where('master_id', $masterId)->update([
				'studio_id' => $studioId
			]);
			return response()->json([
				'status' => 200,
				'message' => 'add master success.'
			], 200);
		}

		public function addStudio()
		{
			$user = \Auth::user();

			if ($user->user_type != 'admin') {
				return redirect('/dashboard/studio');
			}
			$categories = Category::get();
			$masters = Master::join('users', 'users.master_id', 'masters.master_id')->get();
			return view('dashboard-studio-create', ['categories' => $categories, 'masters' => $masters]);
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
				'studio_user' => $inputs['studio_user'],
				'studio_description' => $inputs['studio_description'],
				'studio_location' => $inputs['studio_location'],
				'studio_icon' => $studioData['studio_icon'],
				'studio_bg' => json_encode($studioData['studio_bg']),
				'studio_video' => json_encode($studioData['studio_video']),
			]);
			return redirect()->back()->with('success', 'Create studio data success !');
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
				'studio_user' => $inputs['studio_user'],
				'studio_bg' => json_encode($studioData['studio_bg']),
				'studio_video' => json_encode($studioData['studio_video']),
			]);
			return redirect()->back()->with('success', 'Edit studio data success !');
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
			$user = User::where('user_id', $userId)->first();
			return view('dashboard-user-id', ['users' => $user]);
		}

		public function editUser(Request $request, $userId)
		{
			$inputs = $request->input();
			$files = $request->file();
			if ($inputs['user_email']) {
				$validator = Validator::make($request->all(), [
					'user_email' => 'required|email|unique:users',
				]);
				if ($validator->fails()) {
					return redirect()->back()->withErrors($validator)->withInput();
				}
			}

			if ($inputs['user_password'] != $inputs['confirm_user_password']) {
				return redirect()->back()->withErrors(['message' => 'Password must be equal.'])->withInput();
			}

			$user = [
				'user_name' => $inputs['user_name'],
				'user_password' => Hash::make($inputs['user_password']),
			];

			if ($inputs['user_email']) {
				$user['user_email'] = $inputs['user_email'];
			}

			if (isset($files['user_pic'])) {
				$path = '/img/upload/user/';
				$fileName = time() . '.jpg';
				$files['user_pic']->move(public_path($path), $fileName);
				$user['user_pic'] = $path . $fileName;
			}

			User::where('user_id', $userId)->update($user);
			return redirect()->back()->with('success', 'Edit user data success !');
		}

		public function addUser()
		{
			return view('dashboard-user-create');
		}

		public function createUser(Request $request)
		{
			$validator = Validator::make($request->all(), [
				'user_email' => 'required|email|unique:users',
			]);
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			$inputs = $request->input();
			$files = $request->file();

			if ($inputs['user_password'] != $inputs['confirm_user_password']) {
				return redirect()->back()->withErrors(['message' => 'Password must be equal.'])->withInput();
			}

			$user = [
				'user_name' => $inputs['user_name'],
				'user_email' => $inputs['user_email'],
				'user_password' => Hash::make($inputs['user_password']),
			];

			if (isset($files['user_pic'])) {
				$path = '/img/upload/user/';
				$fileName = time() . '.jpg';
				$files['user_pic']->move(public_path($path), $fileName);
				$user['user_pic'] = $path . $fileName;
			}

			User::create($user);
			return redirect()->back()->with('success', 'Create user data success !');
		}


		public function removeUser($userId)
		{

			User::where('user_id', $userId)->update();
			return redirect()->back();
		}

		public function activities()
		{
			$master = false;
			if (\Auth::user()->user_type != 'admin') {
				$activities = Activity::join('users as u', 'u.user_id', 'activities.user_id')
					->join('masters as m', 'm.master_id', 'u.master_id')
					->where('activities.user_id', \Auth::id())->get();
				$master = true;
			} else {
				$activities = Activity::join('users as u', 'u.user_id', 'activities.user_id')
					->join('masters as m', 'm.master_id', 'u.master_id')->get();
			}
			return view('dashboard-activity', ['activities' => $activities, 'master' => $master]);
		}

		public function activity($activityId)
		{
			$user = \Auth::user();
			$activity = Activity::join('users as u', 'u.user_id', 'activities.user_id')
				->join('masters as m', 'm.master_id', 'u.master_id')
				->where('activities.activity_id', $activityId)
				->first();
			if ($user['user_type'] != 'admin') {
				if ($activity['user_id'] !== $user['user_id']) {
					return redirect()->back();
				}
			}
			$activity['activity_video'] = json_decode($activity['activity_video'], true);
			$activity['activity_pic'] = json_decode($activity['activity_pic'], true);
			$activity['activity_benefit'] = json_decode($activity['activity_benefit'], true);
			$activity['activity_sponsors'] = json_decode($activity['activity_sponsors'], true);

			$categories = Category::get();
			$achievement = Achievement::get();
			$masters = Master::join('users', 'users.master_id', 'masters.master_id')->get();
			return view('dashboard-activity-id', ['activity' => $activity, 'categories' => $categories, 'achievement' => $achievement, 'masters' => $masters]);
		}

		public function editActivity(Request $request, $activityId)
		{
			$user = \Auth::user();
			$inputs = $request->input();
			$files = $request->file();
			$achievement_id = isset($inputs['achievement_id']) ? $inputs['achievement_id'] : '';

			$activityModel = Activity::where('activities.activity_id', $activityId);
			$activity = $activityModel->first();
			if ($user['user_type'] != 'admin') {
				if ($activity['user_id'] !== $user['user_id']) {
					return redirect()->back();
				}
			}

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

			if (isset($inputs['benefit_name'])) {
				foreach ($inputs['benefit_name'] as $i => $bf) {
					$activityData['activity_benefit'][$i]['name'] = $bf;
					$activityData['activity_benefit'][$i]['text'] = $inputs['benefit_desc'][$i];
				}
			}

			if (isset($inputs['sponsor_name'])) {
				foreach ($inputs['sponsor_name'] as $i => $sp) {
					$activityData['activity_sponsor'][$i]['name'] = $sp;
					$activityData['activity_sponsor'][$i]['link'] = $inputs['sponsor_link'][$i];
				}
			}

			if (isset($inputs['achievement_name'])) {
				$achievement = new Achievement;
				$achievement->achievement_name = $inputs['achievement_name'];
				$fileName = time() . '.jpg';
				$files['achievement_pic']->move(public_path($path), $fileName);
				$achievement->achievement_pic = $path . $fileName;
				$achievement->save();
				$achievement_id = $achievement->id;
			}

			$activityModel->update([
				'activity_name' => $inputs['activity_name'],
				'user_id' => isset($inputs['user_id']) ? $inputs['user_id'] : \Auth::id(),
				'category_id' => $inputs['category_id'],
				'achievement_id' => $achievement_id,
				'activity_description' => $inputs['activity_description'],
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
			return redirect()->back()->with('success', 'Edit activity data success !');
		}

		public function createActivity(Request $request)
		{
			$inputs = $request->input();
			$files = $request->file();

			$path = '/img/upload/activity/';
			$activityData = [];
			$activityData['activity_sponsor'] = [];
			$activityData['activity_benefit'] = [];
			$activityData['activity_video'] = [];
			$activityData['activity_pic'] = [];
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

			if (isset($inputs['benefit_name'])) {
				foreach ($inputs['benefit_name'] as $i => $bf) {
					$activityData['activity_benefit'][$i]['name'] = $bf;
					$activityData['activity_benefit'][$i]['text'] = $inputs['benefit_desc'][$i];
				}
			}

			if (isset($inputs['sponsor_name'])) {
				foreach ($inputs['sponsor_name'] as $i => $sp) {
					$activityData['activity_sponsor'][$i]['name'] = $sp;
					$activityData['activity_sponsor'][$i]['link'] = $inputs['sponsor_link'][$i];
				}
			}

			echo "<script>window.open('/activity/" . $inputs['activity_name'] . "', '_blank')</script>";

			$activityId = Activity::create([
				'activity_name' => $inputs['activity_name'],
				'activity_url_name' => $inputs['activity_url_name'],
				'user_id' => isset($inputs['user_id']) ? $inputs['user_id'] : \Auth::id(),
				'category_id' => $inputs['category_id'],
				'achievement_id' => $inputs['achievement_id'],
				'activity_description' => $inputs['activity_description'],
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
				'activity_private' => 1,
				'activity_sponsors' => json_encode($activityData['activity_sponsor']),
				'activity_benefit' => json_encode($activityData['activity_benefit']),
				'activity_video' => json_encode($activityData['activity_video']),
				'activity_pic' => json_encode($activityData['activity_pic']),
			])->id;
			return redirect('/dashboard/activity/' . $activityId);
		}

		public function addActivity()
		{
			$categories = Category::get();
			$achievement = Achievement::get();
			$masters = Master::join('users', 'users.master_id', 'masters.master_id')->get();
			return view('dashboard-activity-create', ['categories' => $categories, 'achievement' => $achievement, 'masters' => $masters]);
		}

		public function publicActivity($activity_id)
		{
			Activity::where('activity_id', $activity_id)->update(['activity_private' => 0]);
			return redirect()->back();
		}

		public function privateActivity($activity_id)
		{
			Activity::where('activity_id', $activity_id)->update(['activity_private' => 1]);
			return redirect()->back();
		}

		public function stories()
		{
			$stories = ActivityStory::from('activity_stories as as')
				->join('activities as act', 'act.activity_id', '=', 'as.activity_id')
				->orderBy('as.activity_story_id', 'desc')
				->where('as.story_status', 'story')
				->select('*', 'as.created_at')->get();
			$lessons = ActivityStory::from('activity_stories as as')
				->join('activities as act', 'act.activity_id', '=', 'as.activity_id')
				->orderBy('as.activity_story_id', 'desc')
				->where('as.story_status', 'lesson')
				->select('*', 'as.created_at')->get();
			return view('dashboard-story', ['stories' => $stories, 'lessons' => $lessons]);
		}

		public function removeStory($storyId)
		{
			$acModel = ActivityStory::where('activity_story_id', $storyId);
			$ac = $acModel->first();
			$user = \Auth::user();
			$me = $ac['user_id'] == $user['user_id'];
			if (!$me && $user['user_type'] != 'admin') {
				return redirect()->back();
			}
			$acModel->delete();
			return redirect()->back();
		}

		public function addMail()
		{
			$users = User::get();
			return view('dashboard-email', ['users' => $users]);
		}

		public function createMail(Request $request)
		{
			$inputs = $request->input();

			if ($inputs['email_sendto'] == 1) {
				$subs = Subscriber::pluck('subscriber_email')->toArray();
				Mail::to($subs)->send(new WebSubscription($inputs['email_subject'], $inputs['email_description']));
			} else if ($inputs['email_sendto'] == 2) {
				$users = User::pluck('user_email')->toArray();
				Mail::to($users)->send(new WebSubscription($inputs['email_subject'], $inputs['email_description']));
			} else if ($inputs['email_sendto'] == 3) {
				$masters = User::whereNotNull('master_id')->pluck('user_email')->toArray();
				Mail::to($masters)->send(new WebSubscription($inputs['email_subject'], $inputs['email_description']));
			} else if ($inputs['email_sendto'] == 4) {
				$user = User::where('user_id', $inputs['email_user'])->first();
				Mail::to($user['user_email'])->send(new WebSubscription($inputs['email_subject'], $inputs['email_description']));
			}

			return redirect()->back();
		}

		public function categories()
		{
			$categories = Category::get();
			return view('dashboard-category', ['categories' => $categories]);
		}

		public function category($categoryId)
		{
			$category = Category::where('category_id', $categoryId)->first();
			return view('dashboard-category-id', ['category' => $category]);
		}

		public function addCategory()
		{
			return view('dashboard-category-create');
		}

		public function createCategory(Request $request)
		{
			Validator::make($request->all(), [
				'category_video' => 'max:102400',
			])->validate();

			$inputs = $request->input();
			$files = $request->file();

			$path = '/img/category/' . $inputs['category_name'] . '/';
			if (isset($files['category_pic'])) {
				$fileName = $inputs['category_name'] . '.jpg';
				$files['category_pic']->move(public_path($path), $fileName);
				$categoryPic = $path . $fileName;
			}
			if (isset($files['category_bg'])) {
				$fileName = $inputs['category_name'] . '.jpg';
				$files['category_bg']->move(public_path($path), $fileName);
				$categoryBg = $path . $fileName;
			}
			if (isset($files['category_video'])) {
				$fileName = $inputs['category_name'] . '.mp4';
				$files['category_video']->move(public_path($path), $fileName);
				$categoryVideo = $path . $fileName;
			}

			Category::create([
				'category_name' => $inputs['category_name'],
				'category_pic' => $categoryPic,
				'category_bg' => $categoryBg,
				'category_video' => $categoryVideo,
			]);

			return redirect()->back()->with('success', 'Create activity data success !');
		}

		public function editCategory(Request $request, $categoryId)
		{
			$inputs = $request->input();
			$files = $request->file();

			$path = '/img/category/' . $inputs['category_name'] . '/';

			$data = [
				'category_name' => $inputs['category_name']
			];

			if (isset($files['category_pic'])) {
				$fileName = $inputs['category_name'] . '.jpg';
				$files['category_pic']->move(public_path($path), $fileName);
				$categoryPic = $path . $fileName;
				$data['category_pic'] = $categoryPic;
			}
			if (isset($files['category_bg'])) {
				$fileName = $inputs['category_name'] . '.jpg';
				$files['category_bg']->move(public_path($path), $fileName);
				$categoryBg = $path . $fileName;
				$data['category_bg'] = $categoryBg;
			}
			if (isset($files['category_video'])) {
				$fileName = $inputs['category_name'] . '.mp4';
				$files['category_video']->move(public_path($path), $fileName);
				$categoryVideo = $path . $fileName;
				$data['category_video'] = $categoryVideo;
			}

			Category::where('category_id', $categoryId)->update($data);

			return redirect()->back()->with('success', 'Update activity data success !');
		}

		public function removeCategory($categoryId)
		{
			Category::where('category_id', $categoryId)->delete();
			return redirect()->back();
		}

	}
