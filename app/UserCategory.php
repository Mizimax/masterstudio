<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class UserCategory extends Model
	{
		//
		protected $table = 'user_category';

		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'category_id', 'user_id'
		];
	}
