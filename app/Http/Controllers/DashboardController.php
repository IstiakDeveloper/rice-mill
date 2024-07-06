<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Bag;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Season;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $accounts = Account::all();
        $expenses = Expense::all();
        $accountTotal = Account::sum("amount");
        $expensesTotal = Expense::sum("amount");
        $balance = $accountTotal - $expensesTotal;

        // Determine the date range based on the request
        $dateOption = $request->input('date_option', 'today'); // default to 'today'
        $specificDate = $request->input('specific_date');
        $startDate = Carbon::today();
        $endDate = Carbon::today();

        switch ($dateOption) {
            case 'yesterday':
                $startDate = Carbon::yesterday();
                $endDate = Carbon::yesterday();
                break;
            case 'last_3_days':
                $startDate = Carbon::today()->subDays(2);
                $endDate = Carbon::today();
                break;
            case 'last_7_days':
                $startDate = Carbon::today()->subDays(6);
                $endDate = Carbon::today();
                break;
            case 'specific_date':
                if ($specificDate) {
                    $startDate = Carbon::parse($specificDate);
                    $endDate = Carbon::parse($specificDate);
                }
                break;
            default:
                $startDate = Carbon::today();
                $endDate = Carbon::today();
                break;
        }

        // Fetch bags and payments for the determined date range
        $bags = Bag::whereBetween('date', [$startDate, $endDate])->get();
        $todayTotalBosta = $bags->sum('bag_amount');
        $todayTotalAmount = $bags->sum(function ($bag) {
            return $bag->bag_amount * $bag->per_bag_price;
        });

        $payments = Payment::whereBetween('date', [$startDate, $endDate])->get();
        $todayTotalPayment = $payments->sum('amount');


        // Retrieve all seasons
        $seasons = Season::all();

        // Default values for selected season
        $selectedSeason = $request->input('selected_season', null);
        $totalBags = 0;
        $totalPayments = 0;
        $totalDue = 0;

        if (!$selectedSeason) {
            $lastSeason = Season::latest()->first();
            if ($lastSeason) {
                $selectedSeason = $lastSeason->id;
            }
        }

        // Fetch data based on selected season
        if ($selectedSeason) {
            $season = Season::find($selectedSeason);
            $bags = Bag::where('season_id', $selectedSeason)->get();
            $bagsTotalAmount = Bag::where('season_id', $selectedSeason)->sum('bag_amount');
            $payments = Payment::where('season_id', $selectedSeason)->get();

            // Calculate totals for bags and payments
            $totalBags = $bags->count();
            $totalPayments = $payments->sum('amount');

            // Calculate total due (if you have a due amount field in your Bag model)
            $totalDue = $bags->sum('total') - $totalPayments;
        }

        if ($request->has('generate_report')) {
            return $this->generateReport();
        }


        return view("dashboard", compact(
            'accountTotal',
            'expensesTotal',
            'accounts',
            'balance',
            'expenses',
            'todayTotalBosta',
            'todayTotalAmount',
            'todayTotalPayment',
            'dateOption',
            'specificDate',
            'seasons',
            'selectedSeason',
            'bagsTotalAmount',
            'totalPayments',
            'totalDue'
        ));
    }

    public function generateReport()
    {
        $customers = Customer::with(['bags', 'payments'])
        ->whereNotIn('name', ['Unknown', 'Aaaaaaaa'])
        ->get();

        $pdf = PDF::loadView('reports.customers', compact('customers'));

        // Return the PDF inline in the browser
        return $pdf->stream('customer_report.pdf');
    }
}
