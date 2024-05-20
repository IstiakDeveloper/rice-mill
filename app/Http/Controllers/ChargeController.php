<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AutoCharge;
use Illuminate\Http\Request;


class ChargeController extends Controller
{
    // Display a listing of the charges
    public function index()
    {
        $charges = AutoCharge::all();
        $totalAmount = AutoCharge::sum('amount');
        return view('admin.charges.index', compact('charges', 'totalAmount'));
    }

    // Show the form for creating a new charge
    public function create()
    {
        return view('admin.charges.create');
    }

    // Store a newly created charge in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'amount' => 'required|numeric',
        ]);

        // Create an AutoCharge instance
        $autoCharge = new AutoCharge();
        $autoCharge->name = $request->input('name');
        $autoCharge->date = $request->input('date');
        $autoCharge->amount = $request->input('amount');
        $autoCharge->save();

        // Create an Account record for the charge
        $account = new Account();
        $account->name = 'Auto Charge'. ' ' . $autoCharge->name;
        $account->date = $autoCharge->date;
        $account->amount = $autoCharge->amount;
        $account->save();


        return redirect()->route('charges.index')->with('success', 'Charge created successfully');
    }

    // Display the specified charge
    public function show(AutoCharge $charge)
    {
        return view('admin.charges.show', compact('charge'));
    }

    // Show the form for editing the specified charge
    public function edit(AutoCharge $charge)
    {
        return view('admin.charges.edit', compact('charge'));
    }

    // Update the specified charge in the database
    public function update(Request $request, AutoCharge $charge)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'amount' => 'required|numeric',
        ]);

        $charge->update($request->all());

        return redirect()->route('charges.index')->with('success', 'Charge updated successfully');
    }

    // Remove the specified charge from the database
    public function destroy(AutoCharge $charge)
    {
        $charge->delete();

        return redirect()->route('charges.index')->with('success', 'Charge deleted successfully');
    }
}
