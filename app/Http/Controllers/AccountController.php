<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AutoCharge;
use App\Models\Expense;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(){
        $accountTotal = Account::sum("amount");
        $expensesTotal = Expense::sum("amount");
        $balance = $accountTotal - $expensesTotal;
        $accounts = Account::all();

        return view('admin.accounts.index', compact('accountTotal', 'expensesTotal', 'accounts', 'balance'));
    }

    public function create(){
        return view('admin.accounts.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'amount' => 'required|numeric',
        ]);

        Account::create($request->all());

        return redirect()->route('accounts.index')->with('success', 'Account added successfully');
    }
}
