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
		session(['user_log_date1' => $request->has('okdate1') ? $request->date1 : session('user_log_date1', date('Y-m-d'))]);
		session(['user_log_date2' => $request->has('okdate2') ? $request->date2 : session('user_log_date2', date('Y-m-d'))]);

		$user_logs = UserLog::where(function($query) {
				$query->whereHas('user', function($query2) {
					$query2->withTrashed();
					$query2->where('name', 'like', '%'.session('user_log_search').'%');
				})
				->orWhere('description', 'like', '%'.session('user_log_search').'%');
			})
			->whereBetween('creation_date', [session('user_log_date1'), session('user_log_date2').' 23:59:59'])
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
