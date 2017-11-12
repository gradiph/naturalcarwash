<?php

namespace App\Http\Controllers;

use App\User;
use App\UserLog;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use Auth;
use DB;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(UserCreateRequest $request)
    {
        DB::beginTransaction();

		$user = User::create([
			'name' => $request->name,
			'username' => $request->username,
			'password' => bcrypt($request->password),
			'level' => $request->level,
		]);
		if($user)
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Membuat pengguna ID #'.$user->id.' ('.$user->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('users.index')->with([
					'alert_messages' => 'Pembuatan pengguna '.$user->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('users.create')->withInput()->with([
			'alert_messages' => 'Pembuatan pengguna '.$request->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function show($user)
    {
        $user = User::withTrashed()->find($user);
		return view('user.show')->with('user', $user);
    }

    public function edit(User $user)
    {
        return view('user.edit')->with('user', $user);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        DB::beginTransaction();

		$user->name = $request->name;
		$user->username = $request->username;
		$user->level = $request->level;
		if($request->has('password')) $user->password = bcrypt($request->password);

		if($user->save())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengubah pengguna ID #'.$user->id.' ('.$user->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('users.index')->with([
					'alert_messages' => 'Pengubahan pengguna '.$user->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('users.edit')->withInput->with([
			'alert_messages' => 'Pengubahan pengguna '.$user->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();

		if($user->delete())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Menonaktifkan pengguna ID #'.$user->id.' ('.$user->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('users.index')->with([
					'alert_messages' => 'Menonaktifkan pengguna '.$user->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('users.index')->with([
			'alert_messages' => 'Menonaktifkan pengguna '.$user->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

	public function dataList(Request $request)
	{
		session(['user_search' => $request->has('oksearch') ? $request->search : session('user_search', '')]);
		session(['user_deleted' => $request->has('deleted') ? $request->deleted : session('user_deleted', '0')]);

		if(session('user_deleted') == '0')
		{
			$users = User::where('name', 'like', '%'.session('user_search').'%')
				->orderBy('level', 'desc')
				->orderBy('name', 'asc')
				->paginate(6);
		}
		else
		{
			$users = User::withTrashed()
				->where('name', 'like', '%'.session('user_search').'%')
				->orderBy('level', 'desc')
				->orderBy('name', 'asc')
				->paginate(6);
		}

		return view('user.list')->with([
			'users' => $users,
		]);
	}

	public function restorePost($user)
	{
		DB::beginTransaction();

		$user = User::onlyTrashed()
			->find($user);

		if($user->restore())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengaktifkan kembali pengguna ID #'.$user->id.' ('.$user->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('users.index')->with([
					'alert_messages' => 'Pengaktifan kembali pengguna '.$user->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('users.index')->with([
			'alert_messages' => 'Pengaktifan kembali pengguna '.$user->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
	}
}
