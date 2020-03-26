<?php

	namespace App\Http\Middleware;

	use Closure;

	class Master
	{
		/**
		 * Handle an incoming request.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param \Closure $next
		 * @return mixed
		 */
		public function handle($request, Closure $next)
		{
			if (\Auth::check() && \Auth::user()->master_id) {
				return $next($request);
			}
			return redirect('/#login');
		}
	}
