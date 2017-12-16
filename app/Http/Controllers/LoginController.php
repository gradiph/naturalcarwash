<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordChangeRequest;
use Illuminate\Http\Request;
use App\UserLog;
use Auth;
use DB;
use Hash;

class LoginController extends Controller
{
	public function index()
	{
		return redirect()->route('login');
	}

	public function login()
	{
		if(Auth::check())
		{
			if(Auth::user()->level->name == 'Admin')
			{
				return redirect()->route('reports.index');
			}
			else
			{
				return redirect()->route('home.index');
			}
		}
		else
		{
			return view('login');
		}
	}

    public function loginPost(LoginRequest $request)
	{
		if(Auth::attempt(['username' => $request->username, 'password' => $request->password], true))
		{
			if(Auth::user()->level->name == 'Admin')
			{
				return redirect()->route('reports.index');
			}
			else
			{
				return redirect()->route('home.index');
			}
		}
		else
		{
			return back()->withInput();
		}
	}

	public function logoutPost(Request $request)
	{
		Auth::logout();

		return redirect('')->with([
			'alert_type' => 'alert-success',
			'alert_messages' => 'Berhasil logout',
		]);
	}

	public function passwordChange()
	{
		return view('password.change');
	}

	public function passwordChangePost(PasswordChangeRequest $request)
	{
		DB::beginTransaction();

		$user = Auth()->user();
		if(Hash::check($request->oldpassword, $user->password))
		{
			$user->password = bcrypt($request->newpassword);
			if($user->save())
			{
				$userLog = UserLog::create([
					'user_id' => $user->id,
					'description' => 'Mengubah password pengguna ID #'.$user->id.' ('.$user->name.')',
					'creation_date' => date('Y-m-d H:i:s'),
				]);
				if($userLog)
				{
					DB::commit();
					return redirect()->route('password.change')->with([
						'alert_messages' => 'Password Anda berhasil diubah',
						'alert_type' => 'alert-success',
					]);
				}
			}
			DB::rollBack();
			return redirect()->route('password.change')->with([
				'alert_messages' => 'Password Anda gagal diubah',
				'alert_type' => 'alert-danger',
			]);
		}
		DB::rollBack();
		return redirect()->route('password.change')->with([
			'error_oldpassword' => 'Password lama salah',
		]);
	}
}
