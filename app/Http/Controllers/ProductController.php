<?php

namespace App\Http\Controllers;

use App\Expenditure;
use App\ExpenditureType;
use App\Product;
use App\ProductType;
use App\UserLog;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\Request;
use Auth;
use DB;

class ProductController extends Controller
{
    public function index()
    {
		$types = ProductType::where('id', '!=', '1')
			->get();

        return view('product.index')->with([
			'types' => $types,
		]);
    }

    public function create()
    {
        $types = ProductType::where('id', '!=', '1')
			->get();

		$products = Product::with('type')
			->orderBy('type_id', 'asc')
			->orderBy('name', 'asc')
			->get();

        return view('product.create')->with([
			'types' => $types,
			'products' => $products,
		]);
    }

    public function store(ProductCreateRequest $request)
    {
        DB::beginTransaction();

		if($request->has('id'))
		{
			$product = Product::find($request->id);
			$product->qty += $request->qty;
			if($product->save())
			{
				$userLog = UserLog::create([
					'user_id' => Auth::id(),
					'description' => 'Menambah stok '.$product->type->name.' ID #'.$product->id.' ('.$product->name.')',
					'creation_date' => date('Y-m-d H:i:s'),
				]);
				if($userLog)
				{
					goto success;
				}
			}
		}
		else
		{
			if($request->type_id == '1')
			{
				$type = ProductType::create([
					'name' => $request->type,
				]);

				$product = Product::create([
					'type_id' => $type->id,
					'name' => $request->name,
					'price' => $request->price,
					'qty' => $request->qty,
				]);
			}
			else
			{
				$product = Product::create([
					'type_id' => $request->type_id,
					'name' => $request->name,
					'price' => $request->price,
					'qty' => $request->qty,
				]);
			}

			if($product)
			{
				$userLog = UserLog::create([
					'user_id' => Auth::id(),
					'description' => 'Membuat '.$product->type->name.' ID #'.$product->id.' ('.$product->name.')',
					'creation_date' => date('Y-m-d H:i:s'),
				]);
				if($userLog)
				{
					goto success;
				}
			}
		}

		DB::rollBack();
		return redirect()->route('products.index')->with([
			'alert_messages' => 'Penambahan stok '.$product->type->name.' '.$product->name.' gagal',
			'alert_type' => 'alert-danger',
		]);

		success:
		DB::commit();
		return redirect()->route('products.index')->with([
			'alert_messages' => 'Penambahan stok '.$product->type->name.' '.$product->name.' berhasil',
			'alert_type' => 'alert-success',
		]);
    }

    public function show($product)
    {
        $product = Product::withTrashed()
			->with('type')
			->find($product);

		return view('product.show')->with('product', $product);
    }

    public function edit(Product $product)
    {
		$types = ProductType::where('id', '!=', '1')
			->get();

		$product->load('type');

		return view('product.edit')->with([
			'product' => $product,
			'types' => $types,
		]);
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        DB::beginTransaction();

		$product->name = $request->name;
		$product->price = $request->price;

		if($request->type_id == '1')
		{
			$type = ProductType::create([
				'name' => $request->type,
			]);

			$product->type_id = $type->id;
		}
		else
		{
			$product->type_id = $request->type_id;
		}

		if($product->save())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengubah '.$product->type->name.' ID #'.$product->id.' ('.$product->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				goto success;
			}
		}

		DB::rollBack();
		return redirect()->route('products.edit', ['product' => $product->id])->withInput()->with([
			'alert_messages' => 'Pengubahan '.$product->type->name.' '.$request->name.' gagal',
			'alert_type' => 'alert-danger',
		]);

		success:
		DB::commit();
		return redirect()->route('products.index')->with([
			'alert_messages' => 'Pengubahan '.$product->type->name.' '.$product->name.' berhasil',
			'alert_type' => 'alert-success',
		]);
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();

		if($product->delete())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Menonaktifkan '.$product->type->name.' ID #'.$product->id.' ('.$product->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				goto success;
			}
		}

		DB::rollBack();
		return redirect()->route('products.index')->with([
			'alert_messages' => 'Menonaktifkan '.$product->type->name.' '.$product->name.' gagal',
			'alert_type' => 'alert-danger',
		]);

		success:
		DB::commit();
		return redirect()->route('products.index')->with([
			'alert_messages' => 'Menonaktifkan '.$product->type->name.' '.$product->name.' berhasil',
			'alert_type' => 'alert-success',
		]);
    }

	public function dataList(Request $request)
	{
		session(['product_search' => $request->has('oksearch') ? $request->search : session('product_search', '')]);
		session(['product_deleted' => $request->has('deleted') ? $request->deleted : session('product_deleted', '0')]);
		session(['product_type' => $request->has('oktype') ? $request->type : session('product_type', '')]);

		$products = Product::with('type')
			->where('name', 'like', '%'.session('product_search').'%');
		if(session('product_deleted') == '0')
		{
			$products->withTrashed();
		}
		if(session('product_type') != '')
		{
			$products->where('type_id', session('product_type'));
		}
		$products->orderBy('type_id', 'asc')
			->orderBy('name', 'asc');

		return view('product.list')->with([
			'products' => $products->paginate(6),
		]);
	}

	public function restorePost($product)
	{
		DB::beginTransaction();

		$product = Product::onlyTrashed()
			->find($product);

		if($product->restore())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengaktifkan kembali '.$product->type->name.' ID #'.$product->id.' ('.$product->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				goto success;
			}
		}
		DB::rollBack();
		return redirect()->route('products.index')->with([
			'alert_messages' => 'Pengaktifan kembali '.$product->type->name.' '.$product->name.' gagal',
			'alert_type' => 'alert-danger',
		]);

		success:
		DB::commit();
		return redirect()->route('products.index')->with([
			'alert_messages' => 'Pengaktifan kembali '.$product->type->name.' '.$product->name.' berhasil',
			'alert_type' => 'alert-success',
		]);
	}

	public function checkId(Request $request)
	{
		$product = Product::where('name', $request->name)
			->first();

		return $product != null ? $product->id : $product;
	}
}
