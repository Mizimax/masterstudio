<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class Studio extends Model
	{
		//
		protected $fillable = [
			'studio_name',
			'studio_title',
			'studio_user',
			'category_id',
			'studio_description',
			'studio_location',
			'studio_icon',
			'studio_bg',
			'studio_video',
			'studio_lat',
			'studio_long'
		];
	}
