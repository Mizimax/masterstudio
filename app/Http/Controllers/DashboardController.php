<?php

	namespace App\Http\Controllers;

	use App\Category;
	use App\Studio;
	use App\User;
	use Illuminate\Http\Request;

	class DashboardController extends Controller
	{
		//

		public function index()
		{
			if (\Auth::user()->user_type == 'user') {
				return view('dashboard-master');
			}
			return view('dashboard-user');
		}

		public function masters()
		{
			return view('dashboard-master');
		}

		public function master()
		{
			return view('dashboard-master-id');
		}

		public function addMaster()
		{
			return view('dashboard-master-create');
		}

		public function createMaster()
		{

		}

		public function editMaster()
		{

		}

		public function removeMaster()
		{

		}


		public function studios()
		{
			$user = \Auth::user();
			if ($user->user_type != 'admin') {
				$studioId = Studio::where('studios.studio_user', $user->user_id)->first();
				return redirect('/dashboard/studio/' . $studioId['studio_id']);
			}
			$studios = Studio::join('categories as cg', 'cg.category_id', 'studios.category_id')->get();
			return view('dashboard-studio', ['studios' => $studios]);
		}

		public function studio($studioId)
		{
			$user = \Auth::user();
			$studios = Studio::where('studios.studio_id', $studioId)->first();
			if ($user->user_type != 'admin' && $studios['studio_user'] != $user['user_id']) {
				return redirect('/dashboard/studio');
			}
			$studios['studio_bg'] = json_decode($studios['studio_bg'], true);
			$studios['studio_video'] = json_decode($studios['studio_video'], true);

			$categories = Category::get();
			return view('dashboard-studio-id', ['studios' => $studios, 'categories' => $categories]);
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

		public function removeUser($userId)
		{
			User::where('user_id', $userId)->delete();
			return redirect()->back();
		}

	}
