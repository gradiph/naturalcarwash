<?php

namespace App\Http\Controllers;

use App\Expenditure;
use App\Transaction;
use Illuminate\Http\Request;
use Auth;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function dataList(Request $request)
    {
		session(['report_mode' => $request->has('okmode') ? $request->mode : session('report_mode', 'daily')]);

		//success transactions
		$success_transactions = Transaction::where('status', '1')
			->where(function($query) {
				$query->where('wash_total', '!=', '0')
					->orWhere('nonwash_total', '!=', '0');
			});

		//canceled transactions
		$canceled_transactions = Transaction::where('status', '0');

		//filter
		if(session('report_mode') == 'daily')
		{
			session(['report_daily_date' => $request->has('okdate') ? $request->date : session('report_daily_date', date('Y-m-d'))]);

			//success transactions
			$success_transactions->whereDate('creation_date', session('report_daily_date'));

			//canceled transactions
			$canceled_transactions->whereDate('creation_date', session('report_daily_date'));

			//expenditures
			$expenditures = Expenditure::whereDate('creation_date', session('report_daily_date'));

			return view('report.list.daily')->with([
				'success_transactions' => $success_transactions->get(),
				'canceled_transactions' => $canceled_transactions->get(),
				'expenditures' => $expenditures->get(),
			]);
		}
		elseif(session('report_mode') == 'monthly')
		{
			session(['report_monthly_month' => $request->has('okmonth') ? $request->month : session('report_monthly_month', date('Y-m'))]);

			//success transactions
			$success_transactions->whereDate('creation_date', 'like', '%'.session('report_monthly_month').'%');

			//expenditures
			$expenditures = Expenditure::whereDate('creation_date', 'like', '%'.session('report_monthly_month').'%');

			return view('report.list.monthly')->with([
				'success_transactions' => $success_transactions->get(),
				'expenditures' => $expenditures->get(),
			]);
		}
		elseif(session('report_mode') == 'annualy')
		{
			session(['report_annualy_year' => $request->has('okyear') ? $request->year : session('report_annualy_year', date('Y'))]);

			//success transactions
			$success_transactions->whereDate('creation_date', 'like', '%'.session('report_annualy_year').'%');

			//expenditures
			$expenditures = Expenditure::whereDate('creation_date', 'like', '%'.session('report_annualy_year').'%');

			return view('report.list.annualy')->with([
				'success_transactions' => $success_transactions->get(),
				'expenditures' => $expenditures->get(),
			]);
		}
		elseif(session('report_mode') == 'custom')
		{
			session(['report_custom_date1' => $request->has('okdate1') ? $request->date1 : session('report_custom_date1', date('Y-m-d'))]);
			session(['report_custom_date2' => $request->has('okdate2') ? $request->date2 : session('report_custom_date2', date('Y-m-d'))]);

			//success transactions
			$success_transactions->whereBetween('creation_date', [session('report_custom_date1'), session('report_custom_date2').' 23:59:59']);

			//expenditures
			$expenditures = Expenditure::whereBetween('creation_date', [session('report_custom_date1'), session('report_custom_date2').' 23:59:59']);

			return view('report.list.custom')->with([
				'success_transactions' => $success_transactions->get(),
				'expenditures' => $expenditures->get(),
			]);
		}
    }
}
