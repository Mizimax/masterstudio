<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class ActivityStory extends Model
	{
		//
		protected $fillable = [
			'activity_id', 'user_id', 'activity_story_video', 'story_highlight', 'story_status'
		];
	}
