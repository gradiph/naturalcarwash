<?php

namespace App\Http\Controllers;

use App\Wash;
use App\UserLog;
use App\Http\Requests\WashCreateRequest;
use App\Http\Requests\WashUpdateRequest;
use Illuminate\Http\Request;
use Auth;
use DB;

class WashController extends Controller
{
    public function index()
    {
        if(Auth::user()->level == 'Admin')
		{
			return view('wash.admin_index');
		}

		return view('wash.cashier_index');
    }

    public function create()
    {
        return view('wash.create');
    }

    public function store(WashCreateRequest $request)
    {
        DB::beginTransaction();

		$wash = Wash::create([
			'name' => $request->name,
		]);
		if($wash)
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Membuat mekanik ID #'.$wash->id.' ('.$wash->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('washs.index')->with([
					'alert_messages' => 'Pembuatan mekanik '.$wash->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('washs.create')->withInput()->with([
			'alert_messages' => 'Pembuatan mekanik '.$request->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function show($wash)
    {
        $wash = Wash::withTrashed()->find($wash);
		return view('wash.show')->with('wash', $wash);
    }

    public function edit(Wash $wash)
    {
        return view('wash.edit')->with('wash', $wash);
    }

    public function update(WashUpdateRequest $request, Wash $wash)
    {
        DB::beginTransaction();

		$wash->name = $request->name;

		if($wash->save())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengubah mekanik ID #'.$wash->id.' ('.$wash->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('washs.index')->with([
					'alert_messages' => 'Pengubahan mekanik '.$wash->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('washs.edit')->withInput->with([
			'alert_messages' => 'Pengubahan mekanik '.$wash->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function destroy(Wash $wash)
    {
        DB::beginTransaction();

		if($wash->delete())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Menonaktifkan mekanik ID #'.$wash->id.' ('.$wash->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('washs.index')->with([
					'alert_messages' => 'Menonaktifkan mekanik '.$wash->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('washs.index')->with([
			'alert_messages' => 'Menonaktifkan mekanik '.$wash->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

	public function dataList(Request $request)
	{
		session(['wash_search' => $request->has('oksearch') ? $request->search : session('wash_search', '')]);
		session(['wash_deleted' => $request->has('deleted') ? $request->deleted : session('wash_deleted', '0')]);

		if(session('wash_deleted') == '0')
		{
			$washs = Wash::where('name', 'like', '%'.session('wash_search').'%')
				->orderBy('name', 'asc')
				->paginate(6);
		}
		else
		{
			$washs = Wash::withTrashed()
				->where('name', 'like', '%'.session('wash_search').'%')
				->orderBy('name', 'asc')
				->paginate(6);
		}

		return view('wash.list')->with([
			'washs' => $washs,
		]);
	}

	public function restorePost($wash)
	{
		DB::beginTransaction();

		$wash = Wash::onlyTrashed()
			->find($wash);

		$wash->deleted_at = null;

		if($wash->save())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengaktifkan kembali mekanik ID #'.$wash->id.' ('.$wash->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('washs.index')->with([
					'alert_messages' => 'Pengaktifan kembali mekanik '.$wash->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('washs.index')->with([
			'alert_messages' => 'Pengaktifan kembali mekanik '.$wash->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
	}
}
