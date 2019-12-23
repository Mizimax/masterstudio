<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class ActivityComment extends Model
	{
		//
		protected $fillable = [
			'activity_id', 'user_id', 'comment_text', 'comment_rate', 'comment_pic'
		];
	}
