<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Season;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Filter by address (area)
        if ($request->has('area')) {
            $area = $request->input('area');
            $query->where('area', 'LIKE', "%$area%");
        }

        // Filter by name
        if ($request->has('name')) {
            $name = $request->input('name');
            $query->where('name', 'LIKE', "%$name%");
        }

        $customers = $query;

        $totalAmount = Bag::sum('total');
        $totalPayment = Payment::sum('amount');

        $selectedSeason = $request->input('season');
        $seasons = Season::all();

        if ($selectedSeason) {
            $totalAmount = Bag::whereHas('season', function ($query) use ($selectedSeason) {
                $query->where('name', $selectedSeason);
            })->sum('total');

            $totalPayment = Payment::whereHas('season', function ($query) use ($selectedSeason) {
                $query->where('name', $selectedSeason);
            })->sum('amount');
        } else {
            $totalAmount = Bag::sum('total');
            $totalPayment = Payment::sum('amount');
        }

        if ($selectedSeason) {
            $customers = $query->whereHas('bags', function ($query) use ($selectedSeason) {
                $query->whereHas('season', function ($q) use ($selectedSeason) {
                    $q->where('name', $selectedSeason);
                });
            });
        } else {
            $customers = $query;
        }


        $customers = $customers->paginate(10);

        return view('admin.customers.index', compact('customers', 'totalAmount', 'totalPayment', 'seasons', 'selectedSeason'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'area' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'phone_number' => 'nullable',
        ]);

        // Upload and save the image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('customer_images', 'public');
            $validatedData['image'] = asset('storage/' . $imagePath);
        }

        $customer = Customer::create($validatedData);

        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'area' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add image validation rules
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('customer_images', 'public');
            $validatedData['image'] = asset('storage/' . $imagePath);
        }

        $validatedData['name'] = $request->input('name');
        $validatedData['area'] = $request->input('area');
        $validatedData['phone_number'] = $request->input('phone_number');

        $customer->update($validatedData);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }



    public function pay(Request $request, Customer $customer)
    {
        $request->validate([
            'payment_amount' => 'required|numeric|min:0',
        ]);

        $paymentAmount = $request->input('payment_amount');
        $customer->total -= $paymentAmount;
        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Payment added successfully.');
    }
}
