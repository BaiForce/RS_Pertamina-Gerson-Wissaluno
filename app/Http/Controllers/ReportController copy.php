<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
{
    $transactionsQuery = Transaction::with('user', 'admin', 'sepeda', 'sepeda.jenis', 'duration');

    // Apply date range filter if provided
    if ($request->has('start_date') && $request->has('end_date')) {
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $transactionsQuery->whereBetween('created_at', [$startDate, $endDate]);
    }

    $transaction = $transactionsQuery->get();

    // Calculate overall total amount + charge
    $overallTotal = $transaction->sum(function($transaction) {
        return $transaction->amount + $transaction->charge;
    });

    // Get current date
    $today = Carbon::now();

    // Calculate total amount + charge for this month
    $thisMonthTotal = $transaction->filter(function ($transaction) use ($today) {
        return Carbon::parse($transaction->created_at)->isSameMonth($today);
    })->sum(function($transaction) {
        return $transaction->amount + $transaction->charge;
    });

    // Calculate total amount + charge for today
    $todayTotal = $transaction->filter(function ($transaction) use ($today) {
        return Carbon::parse($transaction->created_at)->isSameDay($today);
    })->sum(function($transaction) {
        return $transaction->amount + $transaction->charge;
    });

    // Count transactions with status 1 and 2 overall, this month, and today
    $status1OverallCount = Transaction::where('status', 1)->count();
    $status1ThisMonthCount = Transaction::where('status', 1)
        ->whereMonth('created_at', $today->month)
        ->whereYear('created_at', $today->year)
        ->count();
    $status1TodayCount = Transaction::where('status', 1)
        ->whereDate('created_at', $today->toDateString())
        ->count();

    $status2OverallCount = Transaction::where('status', 2)->count();
    $status2ThisMonthCount = Transaction::where('status', 2)
        ->whereMonth('created_at', $today->month)
        ->whereYear('created_at', $today->year)
        ->count();
    $status2TodayCount = Transaction::where('status', 2)
        ->whereDate('created_at', $today->toDateString())
        ->count();

    $no = 1;
    return view('reports.index', compact('transaction', 'no', 'overallTotal', 'thisMonthTotal', 'todayTotal', 'status1OverallCount', 'status1ThisMonthCount', 'status1TodayCount', 'status2OverallCount', 'status2ThisMonthCount', 'status2TodayCount'));
}


    public function export(Request $request)
    {
        // Get transactions based on filters, if any
        $transactions = Transaction::with('user', 'admin', 'sepeda', 'sepeda.jenis', 'duration');

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $transactions->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Get all transactions
        $transactions = $transactions->get();
        // Export to selected format
        $format = $request->input('format');
        if ($format === 'excel') {
            return Excel::download(new TransactionsExport($transactions), 'Laporan-' . Carbon::now()->format('Ymd') . '.xlsx');
        } elseif ($format === 'csv') {
            return Excel::download(new TransactionsExport($transactions), 'Laporan-' . Carbon::now()->format('Ymd') . '.csv', \Maatwebsite\Excel\Excel::CSV);
        } elseif ($format === 'pdf') {
            return Excel::download(new TransactionsExport($transactions), 'Laporan-' . Carbon::now()->format('Ymd') . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }
}
