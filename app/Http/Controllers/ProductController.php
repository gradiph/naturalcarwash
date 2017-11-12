<?php

namespace App\Http\Controllers;

use App\Product;
use App\Purchase;
use App\UserLog;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\Request;
use Auth;
use DB;

class ProductController extends Controller
{
    public function index($type = null)
    {
		if($type != 'Minuman' && $type != 'Parfum' && $type != 'Gelas Kopi')
		{
			return redirect()->route('products.index', ['type' => 'Minuman'])->with([
				'alert_messages' => $type.' tidak ditemukan. Mengembalikan ke semula: Minuman',
				'alert_type' => 'alert-info',
			]);
		}
		session(['product_type' => $type]);
		$type = preg_replace('/\s+/', '', $type);
        return view('product.index')->with('type', $type);
    }

    public function create($type = null)
    {
        if($type != 'Minuman' && $type != 'Parfum' && $type != 'Gelas Kopi')
		{
			return redirect()->route('products.index', ['type' => 'Minuman'])->with([
				'alert_messages' => $type.' tidak ditemukan. Mengembalikan ke semula: Minuman',
				'alert_type' => 'alert-info',
			]);
		}
		session(['product_type' => $type]);
		$type = preg_replace('/\s+/', '', $type);
		return view('product.create')->with('type', $type);
    }

    public function store(ProductCreateRequest $request, $type = null)
    {
        if($type != 'Minuman' && $type != 'Parfum' && $type != 'Gelas Kopi')
		{
			return redirect()->route('products.index', ['type' => 'Minuman'])->with([
				'alert_messages' => $type.' tidak ditemukan. Mengembalikan ke semula: Minuman',
				'alert_type' => 'alert-info',
			]);
		}
		session(['product_type' => $type]);

		DB::beginTransaction();

		if($request->has('id'))
		{
			$product = Product::find($request->id);
			$product->qty += $request->qty;
			if($product->save())
			{
				$purchase = Purchase::create([
					'type' => session('product_type'),
					'name' => $product->name,
					'qty' => $request->qty,
					'price' => $product->price,
					'creation_date' => date('Y-m-d H:i:s'),
					'user_id' => Auth::id(),
				]);
				if($purchase)
				{
					$userLog = UserLog::create([
						'user_id' => Auth::id(),
						'description' => 'Menambah stok '.session('product_type').' ID #'.$product->id.' ('.$product->name.')',
						'creation_date' => date('Y-m-d H:i:s'),
					]);
					if($userLog)
					{
						DB::commit();
						return redirect()->route('products.index', ['type' => session('product_type')])->with([
							'alert_messages' => 'Penambahan stok '.session('product_type').' '.$product->name.' berhasil',
							'alert_type' => 'alert-success',
						]);
					}
				}
			}
			DB::rollBack();
			return redirect()->route('products.index', ['type' => session('product_type')])->withInput()->with([
				'alert_messages' => 'Penambahan stok '.session('product_type').' '.$request->name.' gagal',
				'alert_type' => 'alert-danger',
			]);
		}
		$product = Product::create([
			'type' => session('product_type'),
			'name' => $request->name,
			'price' => $request->price,
			'qty' => $request->qty,
		]);
		if($product)
		{
			$purchase = Purchase::create([
				'type' => session('product_type'),
				'name' => $product->name,
				'qty' => $request->qty,
				'price' => $product->price,
				'creation_date' => date('Y-m-d H:i:s'),
				'user_id' => Auth::id(),
			]);
			if($purchase)
			{
				$userLog = UserLog::create([
					'user_id' => Auth::id(),
					'description' => 'Membuat '.session('product_type').' ID #'.$product->id.' ('.$product->name.')',
					'creation_date' => date('Y-m-d H:i:s'),
				]);
				if($userLog)
				{
					DB::commit();
					return redirect()->route('products.index', ['type' => session('product_type')])->with([
						'alert_messages' => 'Pembuatan '.session('product_type').' '.$product->name.' berhasil',
						'alert_type' => 'alert-success',
					]);
				}
			}
		}
		DB::rollBack();
		return redirect()->route('products.create', ['type' => session('product_type')])->withInput()->with([
			'alert_messages' => 'Pembuatan '.session('product_type').' '.$request->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function show($type = null, $product)
    {
        if($type != 'Minuman' && $type != 'Parfum' && $type != 'Gelas Kopi')
		{
			return redirect()->route('products.index', ['type' => 'Minuman'])->with([
				'alert_messages' => $type.' tidak ditemukan. Mengembalikan ke semula: Minuman',
				'alert_type' => 'alert-info',
			]);
		}
		session(['product_type' => $type]);

		$product = Product::withTrashed()->find($product);
		return view('product.show')->with('product', $product);
    }

    public function edit($type = null, Product $product)
    {
        if($type != 'Minuman' && $type != 'Parfum' && $type != 'Gelas Kopi')
		{
			return redirect()->route('products.index', ['type' => 'Minuman'])->with([
				'alert_messages' => $type.' tidak ditemukan. Mengembalikan ke semula: Minuman',
				'alert_type' => 'alert-info',
			]);
		}
		session(['product_type' => $type]);
		$type = preg_replace('/\s+/', '', $type);

		return view('product.edit')->with([
			'product' => $product,
			'type' => $type,
		]);
    }

    public function update(ProductUpdateRequest $request, $type = null, Product $product)
    {
        if($type != 'Minuman' && $type != 'Parfum' && $type != 'Gelas Kopi')
		{
			return redirect()->route('products.index', ['type' => 'Minuman'])->with([
				'alert_messages' => $type.' tidak ditemukan. Mengembalikan ke semula: Minuman',
				'alert_type' => 'alert-info',
			]);
		}
		session(['product_type' => $type]);

		DB::beginTransaction();

		$product->name = $request->name;
		$product->price = $request->price;
		$product->qty = $request->qty;

		if($product->save())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengubah '.session('product_type').' ID #'.$product->id.' ('.$product->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('products.index', ['type' => session('product_type')])->with([
					'alert_messages' => 'Pengubahan '.session('product_type').' '.$product->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('products.edit', ['type' => session('product_type'), 'product' => $product->id])->withInput()->with([
			'alert_messages' => 'Pengubahan '.session('product_type').' '.$request->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function destroy($type = null, Product $product)
    {
        if($type != 'Minuman' && $type != 'Parfum' && $type != 'Gelas Kopi')
		{
			return redirect()->route('products.index', ['type' => 'Minuman'])->with([
				'alert_messages' => $type.' tidak ditemukan. Mengembalikan ke semula: Minuman',
				'alert_type' => 'alert-info',
			]);
		}
		session(['product_type' => $type]);

		DB::beginTransaction();

		if($product->delete())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Menonaktifkan '.session('product_type').' ID #'.$product->id.' ('.$product->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('products.index', ['type' => session('product_type')])->with([
					'alert_messages' => 'Menonaktifkan '.session('product_type').' '.$product->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('products.index', ['type' => session('product_type')])->with([
			'alert_messages' => 'Menonaktifkan '.session('product_type').' '.$product->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

	public function dataList($type = null, Request $request)
	{
		if($type != 'Minuman' && $type != 'Parfum' && $type != 'Gelas Kopi')
		{
			return redirect()->route('products.index', ['type' => 'Minuman'])->with([
				'alert_messages' => $type.' tidak ditemukan. Mengembalikan ke semula: Minuman',
				'alert_type' => 'alert-info',
			]);
		}
		session(['product_type' => $type]);
		$type = preg_replace('/\s+/', '', $type);

		session([$type.'_search' => $request->has('oksearch') ? $request->search : session($type.'_search', '')]);
		session([$type.'_deleted' => $request->has('deleted') ? $request->deleted : session($type.'_deleted', '0')]);

		if(session($type.'_deleted') == '0')
		{
			$products = Product::where('name', 'like', '%'.session($type.'_search').'%')
				->where('type', session('product_type'))
				->orderBy('name', 'asc')
				->paginate(6);
		}
		else
		{
			$products = Product::withTrashed()
				->where('name', 'like', '%'.session($type.'_search').'%')
				->where('type', session('product_type'))
				->orderBy('name', 'asc')
				->paginate(6);
		}

		return view('product.list')->with([
			'products' => $products,
			'type' => $type,
		]);
	}

	public function restorePost($type = null, $product)
	{
		if($type != 'Minuman' && $type != 'Parfum' && $type != 'Gelas Kopi')
		{
			return redirect()->route('products.index', ['type' => 'Minuman'])->with([
				'alert_messages' => $type.' tidak ditemukan. Mengembalikan ke semula: Minuman',
				'alert_type' => 'alert-info',
			]);
		}
		session(['product_type' => $type]);

		DB::beginTransaction();

		$product = Product::onlyTrashed()
			->find($product);

		if($product->restore())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengaktifkan kembali '.session('product_type').' ID #'.$product->id.' ('.$product->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('products.index', ['type' => session('product_type')])->with([
					'alert_messages' => 'Pengaktifan kembali '.session('product_type').' '.$product->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('products.index', ['type' => session('product_type')])->with([
			'alert_messages' => 'Pengaktifan kembali '.session('product_type').' '.$product->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
	}
}
