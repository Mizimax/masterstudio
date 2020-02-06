<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class UserActivity extends Model
	{
		//
		protected $fillable = [
			'activity_id', 'user_id', 'activity_story_video', 'user_activity_paid', 'user_activity_status'
		];
	}
