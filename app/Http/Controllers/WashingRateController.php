<?php

namespace App\Http\Controllers;

use App\WashingRate;
use App\UserLog;
use App\Http\Requests\WashingRateCreateRequest;
use App\Http\Requests\WashingRateUpdateRequest;
use Illuminate\Http\Request;
use Auth;
use DB;

class WashingRateController extends Controller
{
    public function index()
    {
        return view('washing_rate.index');
    }

    public function create()
    {
        return view('washing_rate.create');
    }

    public function store(WashingRateCreateRequest $request)
    {
        DB::beginTransaction();

		$washing_rate = WashingRate::create([
			'name' => $request->name,
			'price' => $request->price,
		]);
		if($washing_rate)
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Membuat tarif ID #'.$washing_rate->id.' ('.$washing_rate->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('washing-rates.index')->with([
					'alert_messages' => 'Pembuatan tarif '.$washing_rate->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('washing-rates.create')->withInput()->with([
			'alert_messages' => 'Pembuatan tarif '.$request->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function show($washing_rate)
    {
        $washing_rate = WashingRate::withTrashed()->find($washing_rate);
		return view('washing_rate.show')->with('washing_rate', $washing_rate);
    }

    public function edit(WashingRate $washing_rate)
    {
        return view('washing_rate.edit')->with('washing_rate', $washing_rate);
    }

    public function update(WashingRateUpdateRequest $request, WashingRate $washing_rate)
    {
        DB::beginTransaction();

		$washing_rate->name = $request->name;
		$washing_rate->price = $request->price;

		if($washing_rate->save())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengubah tarif ID #'.$washing_rate->id.' ('.$washing_rate->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('washing-rates.index')->with([
					'alert_messages' => 'Pengubahan tarif '.$washing_rate->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('washing-rates.edit')->withInput->with([
			'alert_messages' => 'Pengubahan tarif '.$washing_rate->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function destroy(WashingRate $washing_rate)
    {
        DB::beginTransaction();

		if($washing_rate->delete())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Menonaktifkan tarif ID #'.$washing_rate->id.' ('.$washing_rate->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('washing-rates.index')->with([
					'alert_messages' => 'Menonaktifkan tarif '.$washing_rate->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('washing-rates.index')->with([
			'alert_messages' => 'Menonaktifkan tarif '.$washing_rate->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

	public function dataList(Request $request)
	{
		session(['washing_rate_search' => $request->has('oksearch') ? $request->search : session('washing_rate_search', '')]);
		session(['washing_rate_deleted' => $request->has('deleted') ? $request->deleted : session('washing_rate_deleted', '0')]);

		if(session('washing_rate_deleted') == '0')
		{
			$washing_rates = WashingRate::where('name', 'like', '%'.session('washing_rate_search').'%')
				->orderBy('name', 'asc')
				->paginate(6);
		}
		else
		{
			$washing_rates = WashingRate::withTrashed()
				->where('name', 'like', '%'.session('washing_rate_search').'%')
				->orderBy('name', 'asc')
				->paginate(6);
		}

		return view('washing_rate.list')->with([
			'washing_rates' => $washing_rates,
		]);
	}

	public function restorePost($washing_rate)
	{
		DB::beginTransaction();

		$washing_rate = WashingRate::onlyTrashed()
			->find($washing_rate);

		if($washing_rate->restore())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengaktifkan kembali tarif ID #'.$washing_rate->id.' ('.$washing_rate->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('washing-rates.index')->with([
					'alert_messages' => 'Pengaktifan kembali tarif '.$washing_rate->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('washing-rates.index')->with([
			'alert_messages' => 'Pengaktifan kembali tarif '.$washing_rate->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
	}
}
