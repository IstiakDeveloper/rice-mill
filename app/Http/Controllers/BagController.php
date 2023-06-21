<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;


class BagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Customer $customer)
    {
        $request->validate([
            'bag_amount' => 'required|numeric',
            'bag_size' => 'required|string',
            'per_bag_price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $bag = new Bag();
        $bag->bag_amount = $request->bag_amount;
        $bag->bag_size = $request->bag_size;
        $bag->per_bag_price = $request->per_bag_price;
        $bag->date = $request->date;
        $bag->customer_id = $customer->id; // Use the 'id' property of the $customer model
        $totalPrice = $request->per_bag_price * $request->bag_amount;
        $bag->total = $totalPrice;
        $bag->save();

        // Update the total column in the customers table
        $totalAmount = DB::table('bags')->where('customer_id', $customer->id)->sum('total');
        $customer->total = $totalAmount;
        $customer->save();

        // Retrieve the updated customer model
        $customer = Customer::findOrFail($customer->id);

        // Recalculate the remaining balance
        $remainingBalance = $customer->total - $customer->payments->sum('amount');
        $remainingBalance = max($remainingBalance, 0); // Ensure the remaining balance is not negative

        return redirect()
            ->route('customers.show', $customer)
            ->with('success', 'Bag added successfully.')
            ->with('remainingBalance', $remainingBalance);
    }

    public function pay(Request $request, Customer $customer)
    {
        $paymentAmount = $request->input('payment_amount');
        $paymentDate = $request->input('payment_date');

        // Save payment in the database
        $payment = new Payment();
        $payment->customer_id = $customer->id;
        $payment->amount = $paymentAmount;
        $payment->date = $paymentDate;
        $payment->save();

        // Subtract payment amount from customer's total
        $customer->total -= $paymentAmount;
        $customer->save();

        return redirect()->back()->with('success', 'Payment made successfully!');
    }


public function pdf(Customer $customer)
    {
        // Retrieve the customer with related bags and payments
        $customer = Customer::with(['bags', 'payments'])->findOrFail($customer->id);

        // Generate the PDF content
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        $pdfContent = View::make('bags.pdf', compact('customer'))->render();
        $dompdf->loadHtml($pdfContent);
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Download the PDF file
        return $dompdf->stream('bags.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}