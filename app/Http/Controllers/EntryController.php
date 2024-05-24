<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Bag;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Season;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'required_without:customer_id|string',
            'area' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'image' => 'nullable|image',
            'bag_amount' => 'required|integer',
            'bag_size' => 'required|string',
            'per_bag_price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        if ($request->has('customer_id') && $request->customer_id) {
            $customer = Customer::find($request->customer_id);
            $customer->update([
                'area' => $request->area,
                'phone_number' => $request->phone_number,
            ]);
            if ($request->hasFile('image')) {
                $customer->update(['image' => $request->file('image')->store('customers')]);
            }
        } else {
            $customer = Customer::create([
                'name' => $request->customer_name,
                'area' => $request->area,
                'phone_number' => $request->phone_number,
                'image' => $request->hasFile('image') ? $request->file('image')->store('customers') : null,
            ]);
        }

        // Create a new bag
        $bag = new Bag();
        $bag->bag_amount = $request->bag_amount;
        $bag->bag_size = $request->bag_size;
        $bag->per_bag_price = $request->per_bag_price;
        $bag->date = $request->date;
        $bag->customer_id = $customer->id;

        // Determine the current season
        $season = Season::firstOrCreate(['name' => $this->getCurrentSeason()]);

        // Associate the bag with the season
        $bag->season()->associate($season);

        $totalPrice = $request->per_bag_price * $request->bag_amount;
        $bag->total = $totalPrice;
        $bag->save();

        // Update the total column in the customers table for the specific season
        $totalAmount = Bag::where('customer_id', $customer->id)
                        ->where('season_id', $season->id)
                        ->sum('total');
        $customer->total = $totalAmount;
        $customer->save();
        // Retrieve the updated customer model
        $customer = Customer::findOrFail($customer->id);
        // Recalculate the remaining balance for the specific season
        $remainingBalance = $customer->total - $customer->payments->where('season_id', $season->id)->sum('amount');
        $remainingBalance = max($remainingBalance, 0); // Ensure the remaining balance is not negative

        return redirect()->back()->with('success', 'Entry updated!');
    }


    public function pay(Request $request)
    {
        $request->validate([
            'customer_id2' => 'required|exists:customers,id',
            'payment_amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        $customer = Customer::findOrFail($request->input('customer_id2'));
        $paymentAmount = $request->input('payment_amount');
        $paymentDate = Carbon::now();
        $season = Season::firstOrCreate(['name' => $this->getCurrentSeason()]);
        $payment = new Payment();
        $payment->customer_id = $customer->id;
        $payment->amount = $paymentAmount;
        $payment->date = $paymentDate;
        $payment->season()->associate($season);
        $payment->save();

        //For in accounts save
        $account = new Account();
        $account->name = 'Customer'. ' '. $customer->name;;
        $account->date = $paymentDate;
        $account->amount = $paymentAmount;
        $account->save();

        $customer->refresh();
        $remainingAmount = $customer->total - $customer->payments()->where('season_id', $season->id)->sum('amount');

        return redirect()->back()->with('success', 'Payment made successfully!')->with('remainingAmount', $remainingAmount);
    }




    private function getCurrentSeason() {
        $now = Carbon::now();
        $currentYear = $now->year;

        if ($now->month >= 3 && $now->month <= 8) {
            // March to August is "Aaman" season
            return "Eiri" . $currentYear;
        } else {
            // September to February is "Eiri" season
            return "Aman" . ($now->month >= 9 ? $currentYear : $currentYear - 1);
        }
    }
}
