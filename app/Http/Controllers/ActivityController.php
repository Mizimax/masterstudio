<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;

	class ActivityController extends Controller
	{
		//

		/**
		 * Show all activities page.
		 *
		 * @return Illuminate\Http\Response
		 */
		public function index()
		{

			return view('activity');
		}

		/**
		 * Show a activity page by name parameter.
		 *
		 * @param string $name
		 * @return Illuminate\Http\Response
		 */
		public function show($name)
		{
			return view('activity-detail');
		}

		/**
		 * Show the form for creating a new activity.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
			//
		}

		/**
		 * Store a new activity.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			//
		}

		/**
		 * Show the form for editing a activity.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
			//
		}

		/**
		 * Update a activity.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, $id)
		{
			//
		}

		/**
		 * Remove a activity.
		 *
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
			//
		}
	}
