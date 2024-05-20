<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Expense;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $accounts = Account::all();
        $expenses = Expense::all();
        $accountTotal = Account::sum("amount");
        $expensesTotal = Expense::sum("amount");
        $balance = $accountTotal - $expensesTotal;
        return view("dashboard", compact('accountTotal', 'expensesTotal', 'accounts', 'balance', 'expenses',));
    }
}
