<?php

namespace App\Http\Controllers;

use App\Expenditure;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public function index()
    {
        return view('expenditure.index');
    }

    public function create()
    {
        return view('expenditure.create');
    }

    public function store(MechanicCreateRequest $request)
    {
        DB::beginTransaction();

		$expenditure = Mechanic::create([
			'name' => $request->name,
		]);
		if($expenditure)
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Membuat mekanik ID #'.$expenditure->id.' ('.$expenditure->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('expenditures.index')->with([
					'alert_messages' => 'Pembuatan mekanik '.$expenditure->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('expenditures.create')->withInput()->with([
			'alert_messages' => 'Pembuatan mekanik '.$request->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function show($expenditure)
    {
        $expenditure = Mechanic::withTrashed()->find($expenditure);
		return view('expenditure.show')->with('expenditure', $expenditure);
    }

    public function edit(Mechanic $expenditure)
    {
        return view('expenditure.edit')->with('expenditure', $expenditure);
    }

    public function update(MechanicUpdateRequest $request, Mechanic $expenditure)
    {
        DB::beginTransaction();

		$expenditure->name = $request->name;

		if($expenditure->save())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengubah mekanik ID #'.$expenditure->id.' ('.$expenditure->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('expenditures.index')->with([
					'alert_messages' => 'Pengubahan mekanik '.$expenditure->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('expenditures.edit')->withInput->with([
			'alert_messages' => 'Pengubahan mekanik '.$expenditure->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function destroy(Mechanic $expenditure)
    {
        DB::beginTransaction();

		if($expenditure->delete())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Menonaktifkan mekanik ID #'.$expenditure->id.' ('.$expenditure->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('expenditures.index')->with([
					'alert_messages' => 'Menonaktifkan mekanik '.$expenditure->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('expenditures.index')->with([
			'alert_messages' => 'Menonaktifkan mekanik '.$expenditure->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

	public function dataList(Request $request)
	{
		session(['expenditure_search' => $request->has('oksearch') ? $request->search : session('expenditure_search', '')]);

		$expenditures = Expenditure::whereHas('user', function($query) {
				$query->withTrashed();
				$query->where('name', 'like', '%'.session('expenditure_search').'%');
			})
			->orWhere('description', 'like', '%'.session('expenditure_search').'%')
			->with([
				'user' => function($query) {
					$query->withTrashed();
				},
			])
			->latest('creation_date')
			->paginate(6);

		return view('expenditure.list')->with([
			'expenditures' => $expenditures,
		]);
	}
}
