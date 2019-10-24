<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class Follow extends Model
	{
		//
		protected $fillable = [
			'following_id', 'follower_id'
		];
	}
