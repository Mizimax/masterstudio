<?php

	namespace App;

	use App\Notifications\ResetPassword;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;
	use Illuminate\Support\Str;

	class User extends Authenticatable
	{
		use Notifiable;

		protected $primaryKey = 'user_id';

		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'user_name', 'user_email', 'user_password', 'user_birth', 'master_id'
		];

		/**
		 * The attributes that should be hidden for arrays.
		 *
		 * @var array
		 */
		protected $hidden = [
			'user_password', 'remember_token',
		];

		/**
		 * The attributes that should be cast to native types.
		 *
		 * @var array
		 */
		protected $casts = [
			'email_verified_at' => 'datetime',
		];

//
		public function getAuthPassword()
		{
			return $this->user_password;
		}

		/**
		 * Method to return the email for password reset
		 *
		 * @return string Returns the User Email Address
		 */
		public function getEmailForPasswordReset()
		{
			return $this->user_email;
		}

		public function routeNotificationFor($driver)
		{
			if (method_exists($this, $method = 'routeNotificationFor' . Str::studly($driver))) {
				return $this->{$method}();
			}
			return $this->user_email;

		}

		public function sendPasswordResetNotification($token)
		{
			$data = [
				'name' => $this->user_name
			];
			$this->notify(new ResetPassword($data, $token));
		}

	}
