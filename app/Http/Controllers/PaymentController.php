<?php

	namespace App\Http\Controllers;

	use App\Activity;
	use App\Master;
	use App\User;
	use App\UserActivity;
	use Illuminate\Http\Request;
	use App\Services\Omise;

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

			$userId = Activity::select('user_id')->where('activity_id', $id)->first();
			$userActivity = User::select('master_id')->where('user_id', $userId['user_id'])->first();
			Master::where('master_id', $userActivity['master_id'])->update(['master_disciple' => \DB::raw('master_disciple+1')]);

			return redirect()->back()->with('success', ['Payment success!']);

		}
	}
