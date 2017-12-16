<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeAddBeverageRequest;
use App\Http\Requests\HomeCancelTransactionRequest;
use App\Http\Requests\HomeStoreWashRequest;
use Illuminate\Http\Request;
use App\Mechanic;
use App\Product;
use App\Transaction;
use App\UserLog;
use App\Wash;
use App\WashingRate;
use Auth;
use DB;

class HomeController extends Controller
{
    public function index()
	{
        $washes = Wash::all();

		return view('home.index')->with([
			'washes' => $washes,
		]);
	}

	public function createWash()
	{
		$mechanics = Mechanic::all();
		$washing_rates = WashingRate::all();

		return view('home.create.wash')->with([
			'mechanics' => $mechanics,
			'washing_rates' => $washing_rates,
		]);
	}

	public function storeWash(HomeStoreWashRequest $request)
	{
		DB::beginTransaction();

		$transaction = Transaction::create([
			'user_id' => Auth::id(),
			'type' => $request->type,
			'worker_description' => $request->has('description') ? $request->description : null,
			'creation_date' => date('Y-m-d H:i:s'),
			'status' => '1',
			'cancel_reason' => null,
		]);
		if($transaction)
		{
			$wash = Wash::create([
				'transaction_id' => $transaction->id,
				'description' => $request->washdescription,
			]);

			if($wash)
			{
				foreach($request->washing_rate_id as $washing_rate_id)
				{
					$countBefore = $wash->rates()->count();

					$washingRate = WashingRate::find($washing_rate_id);
					$wash->rates()->attach($washingRate->id, ['price' => $washingRate->price]);

					$countAfter = $wash->rates()->count();

					if($countAfter <= $countBefore)
					{
						goto error;
					}
				}

				if($request->has('mechanic_id'))
				{
					foreach($request->mechanic_id as $mechanic_id)
					{
						$countBefore = $transaction->mechanics()->count();

						$mechanic = Mechanic::find($mechanic_id);
						$transaction->mechanics()->attach($mechanic->id);

						$countAfter = $transaction->mechanics()->count();

						if($countAfter <= $countBefore)
						{
							goto error;
						}
					}
				}

				DB::commit();
				return redirect()->route('home.index')->with([
					'alert_messages' => 'Berhasil membuat data cucian baru',
					'alert_type' => 'alert-success',
				]);
			}
		}

		error:
		DB::rollBack();
		return redirect()->route('home.index')->with([
			'alert_messages' => 'Gagal membuat data cucian baru',
			'alert_type' => 'alert-danger',
		]);
	}

	public function calculateWash(Wash $wash)
	{
		$washing_rates = $wash->rates;
		$transaction = $wash->transaction;
		$transaction->load([
			'mechanics' => function($query) {
				$query->withTrashed();
			},
			'products' => function($query) {
				$query->withTrashed();
			},
		]);

		return view('home.calculate.wash')->with([
			'wash' => $wash,
			'washing_rates' => $washing_rates,
			'transaction' => $transaction,
		]);
	}

	public function addBeverage(Wash $wash)
	{
		$transaction = $wash->transaction;

		return view('home.add.beverage')->with([
			'wash' => $wash,
			'transaction' => $transaction,
		]);
	}

	public function showProduct($name = "")
	{
		$products = Product::where('name', 'like', '%'.$name.'%')
			->with('type')
			->take(4)
			->orderBy('name', 'asc')
			->get();

		return view('home.show.product')->with([
			'products' => $products,
		]);
	}

	public function addBeveragePost(Wash $wash, HomeAddBeverageRequest $request)
	{
		DB::beginTransaction();

		$product = Product::find($request->product_id);
		$product->qty -= $request->qty;
		if($product->save() && $product->qty >= 0)
		{
			$transaction = $wash->transaction;
			$countBefore = $transaction->products()->count();
			$transaction->products()->attach($request->product_id, [
				'qty' => $request->qty,
				'price' => $product->price,
			]);
			$countAfter = $transaction->products()->count();
			if($countAfter <= $countBefore)
			{
				goto error;
			}

			DB::commit();
			return redirect()->route('home.index')->with([
				'alert_messages' => 'Berhasil menambahkan '.$request->qty.' '.$product->name,
				'alert_type' => 'alert-success',
			]);
		}

		error:
		DB::rollBack();
		return redirect()->route('home.index')->with([
			'alert_messages' => 'Gagal menambahkan '.$request->qty.' '.$product->name,
			'alert_type' => 'alert-danger',
		]);
	}

	public function checkWashDelete(Wash $wash)
	{
		if($wash->delete())
		{
			return redirect()->route('home.print.invoice', ['transaction' => $wash->transaction_id])->with([
				'transaction' => $wash->transaction,
			]);
		}
		return redirect()->route('home.index')->with([
			'alert_messages' => 'Gagal menutup cucian kendaraan '.$wash->description,
			'alert_type' => 'alert-danger',
		]);
	}

	public function storeNonWashTransaction(Request $request)
	{
		DB::beginTransaction();

		$transaction = Transaction::create([
			'user_id' => Auth::id(),
			'type' => $request->type == '1' ? 'Umum' : 'Karyawan',
			'description' => $request->has('description') ? $request->description : null,
			'creation_date' => date('Y-m-d H:i:s'),
			'status' => '1',
			'cancel_reason' => null,
		]);
		if($transaction)
		{
			for($i = 0; $i < count($request->product_id); $i++) {
				$product = Product::find($request->product_id[$i]);
				$product->qty -= $request->qty[$i];
				if($product->save() && $product->qty >= 0)
				{
					$countBefore = $transaction->products()->count();
					$transaction->products()->attach($product->id, [
						'qty' => $request->qty[$i],
						'price' => $product->price,
					]);
					$countAfter = $transaction->products()->count();
					if($countAfter <= $countBefore)
					{
						goto error;
					}
				}
				else goto error;
			}

			DB::commit();
			return redirect()->route('home.print.invoice', ['transaction' => $transaction->id])->with([
				'transaction' => $transaction,
			]);
		}

		error:
		DB::rollBack();
		return redirect()->route('home.index')->with([
			'alert_messages' => 'Gagal membuat transaksi noncucian baru',
			'alert_type' => 'alert-danger',
		]);
	}

	public function printInvoice(Transaction $transaction)
	{
		$transaction->load([
			'wash' => function($query) {
				$query->withTrashed();
			},
			'products' => function($query) {
				$query->withTrashed();
			},
			'user' => function($query) {
				$query->withTrashed();
			},
			'mechanics' => function($query) {
				$query->withTrashed();
			},
		]);

		return view('home.print.invoice')->with([
			'transaction' => $transaction,
			'wash' => $transaction->wash,
			'products' => $transaction->products,
			'mechanics' => $transaction->mechanics,
		]);
	}

	public function cancelTransaction(Transaction $transaction, HomeCancelTransactionRequest $request)
	{
		DB::beginTransaction();

		$transaction->status = '0';
		$transaction->cancel_reason = $request->reason;

		if($transaction->save())
		{
			foreach($transaction->products as $product)
			{
				$product->qty += $product->pivot->qty;
				if(!$product->save())
				{
					goto error;
				}

				$countBefore = $transaction->products()->count();
				$transaction->products()->detach($product->id);
				$countAfter = $transaction->products()->count();
				if($countAfter >= $countBefore)
				{
					goto error;
				}
			}

			$transaction->wash->delete();

			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'membatalkan transaksi nomor #'.$transaction->id,
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				goto success;
			}
		}

		error:
		DB::rollBack();
		return redirect()->route('home.index')->with([
			'alert_messages' => 'Gagal membatalkan transaksi nomor #'.$transaction->id,
			'alert_type' => 'alert-danger',
		]);

		success:
		DB::commit();
		return redirect()->route('home.index')->with([
			'alert_messages' => 'Berhasil membatalkan transaksi nomor #'.$transaction->id,
			'alert_type' => 'alert-success',
		]);
	}

	public function docs() {
		return view('docs');
	}
}
