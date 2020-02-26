<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class UserAchievement extends Model
	{
		//
		protected $fillable = [
			'category_id', 'user_id', 'achievement_id'
		];
	}
