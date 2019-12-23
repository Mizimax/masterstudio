<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class StudioReview extends Model
	{
		//
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'studio_id', 'user_id', 'review_text'
		];
	}
