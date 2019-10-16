<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;

	class ContentController extends Controller
	{
		//

		/**
		 * Show some activity to grid view.
		 *
		 * @return Illuminate\Http\Response
		 */
		public function activity()
		{
			return view('profile');
		}
	}
