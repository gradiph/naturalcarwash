<?php

namespace App\Http\Controllers;

use App\Tool;
use App\UserLog;
use App\Http\Requests\ToolCreateRequest;
use App\Http\Requests\ToolUpdateRequest;
use Illuminate\Http\Request;
use Auth;
use DB;

class ToolController extends Controller
{
    public function index()
    {
        return view('tool.index');
    }

    public function create()
    {
        return view('tool.create');
    }

    public function store(ToolCreateRequest $request)
    {
        DB::beginTransaction();

		$tool = Tool::create([
			'name' => $request->name,
			'qty' => $request->qty,
			'status' => $request->status,
		]);
		if($tool)
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Membuat peralatan ID #'.$tool->id.' ('.$tool->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('tools.index')->with([
					'alert_messages' => 'Pembuatan peralatan '.$tool->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('tools.create')->withInput()->with([
			'alert_messages' => 'Pembuatan peralatan '.$request->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function show(Tool $tool)
    {
		return view('tool.show')->with('tool', $tool);
    }

    public function edit(Tool $tool)
    {
        return view('tool.edit')->with('tool', $tool);
    }

    public function update(ToolUpdateRequest $request, Tool $tool)
    {
        DB::beginTransaction();

		$tool->name = $request->name;
		$tool->qty = $request->qty;
		$tool->status = $request->status;

		if($tool->save())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Mengubah peralatan ID #'.$tool->id.' ('.$tool->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('tools.index')->with([
					'alert_messages' => 'Pengubahan peralatan '.$tool->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('tools.edit')->withInput->with([
			'alert_messages' => 'Pengubahan peralatan '.$tool->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

    public function destroy(Tool $tool)
    {
        DB::beginTransaction();

		if($tool->delete())
		{
			$userLog = UserLog::create([
				'user_id' => Auth::id(),
				'description' => 'Menghapus peralatan ID #'.$tool->id.' ('.$tool->name.')',
				'creation_date' => date('Y-m-d H:i:s'),
			]);
			if($userLog)
			{
				DB::commit();
				return redirect()->route('tools.index')->with([
					'alert_messages' => 'Menghapus peralatan '.$tool->name.' berhasil',
					'alert_type' => 'alert-success',
				]);
			}
		}
		DB::rollBack();
		return redirect()->route('tools.index')->with([
			'alert_messages' => 'Menghapus peralatan '.$tool->name.' gagal',
			'alert_type' => 'alert-danger',
		]);
    }

	public function dataList(Request $request)
	{
		session(['tool_search' => $request->has('oksearch') ? $request->search : session('tool_search', '')]);

		$tools = Tool::where('name', 'like', '%'.session('tool_search').'%')
				->orderBy('name', 'asc')
				->paginate(6);

		return view('tool.list')->with([
			'tools' => $tools,
		]);
	}
}
