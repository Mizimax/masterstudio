<?php

namespace App\Http\Controllers\Auth;

use App\Follow;
use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'user_firstname' => ['required', 'string', 'max:255'],
			'user_surname' => ['required', 'string', 'max:255'],
			'user_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'user_day' => ['required', 'integer'],
			'user_month' => ['required', 'integer'],
			'user_year' => ['required', 'integer'],
			'user_password' => ['required', 'string', 'min:8', 'confirmed'],
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param array $data
	 * @return \App\User
	 */
	protected function create(array $data)
	{
		$date = \Carbon\Carbon::parse($data['user_day'] . '-' . $data['user_month'] . '-' . $data['user_year'])->format('Y-m-d');
		$user = User::create([
			'user_name' => $data['user_firstname'] . ' ' . $data['user_surname'],
			'user_email' => $data['user_email'],
			'user_birth' => $date,
			'user_password' => Hash::make($data['user_password']),
		]);

		Follow::create([
			'following_id' => $user['user_id'],
			'follower_id' => $user['user_id'],
			'follow_type' => 'user'
		]);
		return $user;
	}

}
