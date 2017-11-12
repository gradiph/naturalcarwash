<?php

namespace App\Http\Controllers;

use App\Mechanic;
use App\UserLog;
use App\Http\Requests\MechanicCreateRequest;
use App\Http\Requests\MechanicUpdateRequest;
use Illuminate\Http\Request;
use Auth;
use DB;

class MechanicController extends Controller
{
    public function index()
    {
        return view('mechanic.index');
    }

    public function create()
    {
        return view('mechanic.create');
    }

    public function store(MechanicCreateRequest $request)
    {
        DB::beginTransaction();

		$mechanic = Mechanic::create([
			'name' => $request->name,
		]);
		if($mechanic)
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Membuat mekanik ID #'.$mechanic->id.' ('.$mechanic->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('mechanics.index')->with([
					'alert_messages' => 'Pembuatan mekanik '.$mechanic->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('mechanics.create')->withInput()->with([
			'alert_messages' => 'Pembuatan mekanik '.$request->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function show($mechanic)
    {
        $mechanic = Mechanic::withTrashed()->find($mechanic);
		return view('mechanic.show')->with('mechanic', $mechanic);
    }

    public function edit(Mechanic $mechanic)
    {
        return view('mechanic.edit')->with('mechanic', $mechanic);
    }

    public function update(MechanicUpdateRequest $request, Mechanic $mechanic)
    {
        DB::beginTransaction();

		$mechanic->name = $request->name;

		if($mechanic->save())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengubah mekanik ID #'.$mechanic->id.' ('.$mechanic->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('mechanics.index')->with([
					'alert_messages' => 'Pengubahan mekanik '.$mechanic->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('mechanics.edit')->withInput->with([
			'alert_messages' => 'Pengubahan mekanik '.$mechanic->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function destroy(Mechanic $mechanic)
    {
        DB::beginTransaction();

		if($mechanic->delete())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Menonaktifkan mekanik ID #'.$mechanic->id.' ('.$mechanic->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('mechanics.index')->with([
					'alert_messages' => 'Menonaktifkan mekanik '.$mechanic->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('mechanics.index')->with([
			'alert_messages' => 'Menonaktifkan mekanik '.$mechanic->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

	public function dataList(Request $request)
	{
		session(['mechanic_search' => $request->has('oksearch') ? $request->search : session('mechanic_search', '')]);
		session(['mechanic_deleted' => $request->has('deleted') ? $request->deleted : session('mechanic_deleted', '0')]);

		if(session('mechanic_deleted') == '0')
		{
			$mechanics = Mechanic::where('name', 'like', '%'.session('mechanic_search').'%')
				->orderBy('name', 'asc')
				->paginate(6);
		}
		else
		{
			$mechanics = Mechanic::withTrashed()
				->where('name', 'like', '%'.session('mechanic_search').'%')
				->orderBy('name', 'asc')
				->paginate(6);
		}

		return view('mechanic.list')->with([
			'mechanics' => $mechanics,
		]);
	}

	public function restorePost($mechanic)
	{
		DB::beginTransaction();

		$mechanic = Mechanic::onlyTrashed()
			->find($mechanic);

		if($mechanic->restore())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengaktifkan kembali mekanik ID #'.$mechanic->id.' ('.$mechanic->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('mechanics.index')->with([
					'alert_messages' => 'Pengaktifan kembali mekanik '.$mechanic->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('mechanics.index')->with([
			'alert_messages' => 'Pengaktifan kembali mekanik '.$mechanic->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
	}
}
