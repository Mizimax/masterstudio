<?php

	namespace App\Http\Controllers;

	use Auth;
	use \App\UserCategory;

	class CategoryController extends Controller
	{
		//
		public function addInterest($categoryId)
		{
			if (!Auth::check()) {
				return response()->json(['status' => 'failed', 'message' => 'You are not logged in.'], 401);
			}
			$userCategory = UserCategory::create(['category_id' => $categoryId, 'user_id' => Auth::id()]);
			if (!$userCategory->exists) {
				return response()->json(['status' => 'failed', 'message' => 'Failed to add ' . $categoryId . ' interesting category.'], 400);
			}
			return response()->json(['status' => 'success', 'message' => 'Adding ' . $categoryId . ' interesting category is success.'], 201);
		}

		public function removeInterest($categoryId)
		{
			if (!Auth::check()) {
				return response()->json(['status' => 'failed', 'message' => 'You are not logged in.'], 401);
			}
			UserCategory::where('user_id', Auth::id())->where('category_id', $categoryId)->delete();

			return response()->json(['status' => 'success', 'message' => 'Removing ' . $categoryId . ' interesting category is success.'], 200);
		}
	}
