<?php

namespace App\Http\Controllers;

use App\UserLog;
use Illuminate\Http\Request;
use Auth;
use DB;

class UserLogController extends Controller
{
    public function index()
    {
        return view('user_log.index');
    }

    public function show(UserLog $user_log)
    {
		$user_log->load([
			'user' => function($query) {
				$query->withTrashed();
			},
		]);

		return view('user_log.show')->with('user_log', $user_log);
    }

	public function dataList(Request $request)
	{
		session(['user_log_search' => $request->has('oksearch') ? $request->search : session('user_log_search', '')]);

		$user_logs = UserLog::whereHas('user', function($query) {
			$query->withTrashed();
			$query->where('name', 'like', '%'.session('user_log_search').'%');
		})
			->orWhere('description', 'like', '%'.session('user_log_search').'%')
			->with([
				'user' => function($query) {
					$query->withTrashed();
				},
			])
			->latest('creation_date')
			->paginate(6);

		return view('user_log.list')->with([
			'user_logs' => $user_logs,
		]);
	}
}
