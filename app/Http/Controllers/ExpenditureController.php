<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenditureCreateRequest;
use App\Http\Requests\ExpenditureUpdateRequest;
use App\Expenditure;
use App\ExpenditureType;
use App\UserLog;
use Illuminate\Http\Request;
use Auth;
use DB;

include_once(app_path().'/functions/indonesian_currency.php');

class ExpenditureController extends Controller
{
    public function index()
    {
		$types = ExpenditureType::where('id', '!=', '1')
			->get();

        return view('expenditure.index')->with([
			'types' => $types,
		]);
    }

    public function create()
    {
        $types = ExpenditureType::where('id', '!=', '1')
			->get();

        return view('expenditure.create')->with([
			'types' => $types,
		]);
    }

    public function store(ExpenditureCreateRequest $request)
    {
        DB::beginTransaction();

		if($request->type_id == '1')
		{
			$type = ExpenditureType::create([
				'name' => $request->type,
			]);

			$expenditure = Expenditure::create([
				'type_id' => $type->id,
				'description' => $request->description,
				'price' => $request->price,
				'user_id' => Auth::id(),
        		'creation_date' => $request->date . date(' H:i:s'),
			]);
		}
		else
		{
			$expenditure = Expenditure::create([
				'type_id' => $request->type_id,
				'description' => $request->description,
				'price' => $request->price,
				'user_id' => Auth::id(),
        		'creation_date' => $request->date . date(' H:i:s'),
			]);
		}

		if($expenditure)
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Membuat pengeluaran jenis '.$expenditure->type->name.' ID #'.$expenditure->id.' ('.indo_currency($expenditure->price).')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				goto success;
			}
		}

		DB::rollBack();
		return redirect()->route('expenditures.index')->with([
			'alert_messages' => 'Penambahan pengeluaran '.$expenditure->type->name.' '.$expenditure->name.' gagal',
			'alert_type' => 'alert-danger',
		]);

		success:
		DB::commit();
		return redirect()->route('expenditures.index')->with([
			'alert_messages' => 'Penambahan pengeluaran '.$expenditure->type->name.' '.$expenditure->name.' berhasil',
			'alert_type' => 'alert-success',
		]);
    }

    public function show(Expenditure $expenditure)
    {
		return view('expenditure.show')->with('expenditure', $expenditure);
    }

    public function edit(Expenditure $expenditure)
    {
		$types = ExpenditureType::where('id', '!=', '1')
			->get();

		$expenditure->load('type');

		return view('expenditure.edit')->with([
			'expenditure' => $expenditure,
			'types' => $types,
		]);
    }

    public function update(ExpenditureUpdateRequest $request, Expenditure $expenditure)
    {
        DB::beginTransaction();

		$expenditure->creation_date = $request->date;
		$expenditure->description = $request->description;
		$expenditure->price = $request->price;

		if($request->type_id == '1')
		{
			$type = ExpenditureType::create([
				'name' => $request->type,
			]);

			$expenditure->type_id = $type->id;
		}
		else
		{
			$expenditure->type_id = $request->type_id;
		}

		if($expenditure->save())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengubah pengeluaran jenis '.$expenditure->type->name.' ID #'.$expenditure->id.' ('.indo_currency($expenditure->price).')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				goto success;
			}
		}

		DB::rollBack();
		return redirect()->route('expenditures.edit', ['expenditure' => $expenditure->id])->withInput()->with([
			'alert_messages' => 'Pengubahan pengeluaran '.$expenditure->type->name.' '.$request->name.' gagal',
			'alert_type' => 'alert-danger',
		]);

		success:
		DB::commit();
		return redirect()->route('expenditures.index')->with([
			'alert_messages' => 'Pengubahan pengeluaran '.$expenditure->type->name.' '.$expenditure->name.' berhasil',
			'alert_type' => 'alert-success',
		]);
    }

    public function destroy(Expenditure $expenditure)
    {
        DB::beginTransaction();

		if($expenditure->delete())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Menghapus pengeluaran jenis '.$expenditure->type->name.' ID #'.$expenditure->id.' ('.indo_currency($expenditure->price).')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				goto success;
			}
		}

		DB::rollBack();
		return redirect()->route('expenditures.index')->with([
			'alert_messages' => 'Menghapus pengeluaran '.$expenditure->type->name.' '.$expenditure->name.' gagal',
			'alert_type' => 'alert-danger',
		]);

		success:
		DB::commit();
		return redirect()->route('expenditures.index')->with([
			'alert_messages' => 'Menghapus pengeluaran '.$expenditure->type->name.' '.$expenditure->name.' berhasil',
			'alert_type' => 'alert-success',
		]);
    }

	public function dataList(Request $request)
	{
		session(['expenditure_search' => $request->has('oksearch') ? $request->search : session('expenditure_search', '')]);
		session(['expenditure_type' => $request->has('oktype') ? $request->type : session('expenditure_type', '')]);

		$expenditures = Expenditure::with('type')
			->where(function($query) {
				$query->where('description', 'like', '%'.session('expenditure_search').'%')
					->orWhereHas('user', function($query2) {
						$query2->withTrashed()
							->where('name', 'like', '%'.session('expenditure_search').'%');
					});
			});
		if(session('expenditure_type') != '')
		{
			$expenditures->where('type_id', session('expenditure_type'));
		}
		$expenditures->latest('creation_date');

		return view('expenditure.list')->with([
			'expenditures' => $expenditures->paginate(6),
		]);
	}

	public function restorePost($expenditure)
	{
		DB::beginTransaction();

		$expenditure = Expenditure::onlyTrashed()
			->find($expenditure);

		if($expenditure->restore())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengaktifkan kembali '.$expenditure->type->name.' ID #'.$expenditure->id.' ('.$expenditure->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				goto success;
			}
		}
		DB::rollBack();
		return redirect()->route('expenditures.index')->with([
			'alert_messages' => 'Pengaktifan kembali '.$expenditure->type->name.' '.$expenditure->name.' gagal',
			'alert_type' => 'alert-danger',
		]);

		success:
		DB::commit();
		return redirect()->route('expenditures.index')->with([
			'alert_messages' => 'Pengaktifan kembali '.$expenditure->type->name.' '.$expenditure->name.' berhasil',
			'alert_type' => 'alert-success',
		]);
	}

	public function checkId(Request $request)
	{
		$expenditure = Expenditure::where('name', $request->name)
			->first();

		return $expenditure != null ? $expenditure->id : $expenditure;
	}
}
