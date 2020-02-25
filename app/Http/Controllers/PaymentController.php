<?php

	namespace App\Http\Controllers;

	use App\Activity;
	use App\Master;
	use App\Services\Omise;
	use App\User;
	use App\UserActivity;
	use App\UserCategory;
	use Illuminate\Http\Request;

	class PaymentController extends Controller
	{
		//

		public function payment(Request $request, $id)
		{
			$input = $request->input();
			$charge = Omise::charge([
				'amount' => (int)$input["amount"] * 100,
				'currency' => 'thb',
				'card' => $input["omiseToken"]
			]);

			if ($charge['status'] !== 'successful') {
				return redirect()->back()->withErrors(['error', 'Card error!']);
			}

			$ua = UserActivity::where('activity_id', $id)->where('user_id', \Auth::id());
			if ($ua->exists()) {
				$ua->update([
					'user_activity_paid' => 1
				]);
			} else {
				UserActivity::create([
					'activity_id' => $id,
					'user_id' => \Auth::id(),
					'user_activity_status' => 0,
					'user_activity_paid' => 1
				]);
			}

			$userId = \Auth::id();

			//Update disciple
			$activity = Activity::select('user_id', 'activity_hour', 'category_id')->where('activity_id', $id)->first();
			$masterActivity = User::select('master_id')->where('user_id', $activity['user_id'])->first();
			Master::where('master_id', $masterActivity['master_id'])->update(['master_disciple' => \DB::raw('master_disciple+1')]);

			//Update category, user level

			User::where('user_id', $userId)->update([
				'user_exp' => \DB::raw('user_exp+' . (20 * $activity['activity_hour'])),
				'user_hour' => \DB::raw('user_hour+' . $activity['activity_hour']),
			]);
			$userActivity = User::join('exp', 'exp.exp_up', '<=', 'users.user_exp')
				->where('user_id', $userId)
				->orderBy('exp_up', 'desc')
				->select('exp_level')
				->first();
			User::where('user_id', $userId)->update([
				'user_level' => (int)$userActivity['exp_level'] + 1
			]);

			UserCategory::where('user_id', $userId)
				->where('category_id', $activity['category_id'])
				->update([
					'user_exp' => \DB::raw('user_exp+' . (20 * $activity['activity_hour'])),
					'user_hour' => \DB::raw('user_hour+' . $activity['activity_hour']),
				]);
			$ug = UserCategory::join('exp', 'exp.exp_up', '<=', 'user_category.user_exp')
				->where('user_id', $userId)
				->where('category_id', $activity['category_id'])
				->orderBy('exp_up', 'desc')
				->select('exp_level')->first();
			UserCategory::where('user_id', $userId)
				->where('category_id', $activity['category_id'])
				->update([
					'user_level' => (int)$ug['exp_level'] + 1
				]);

			return redirect()->back()->with('success', ['Payment success!']);

		}
	}
