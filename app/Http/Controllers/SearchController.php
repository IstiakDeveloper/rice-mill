<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Season;
use Illuminate\Http\Request;

class SearchController extends Controller
{
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

        if ($request->has('phone_number')) {
            $phone_number = $request->input('phone_number');
            $query->where('phone_number', 'LIKE', "%$phone_number%");
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


        // Check if a search query is stored in the session
        $search = $request->input('search');
        $customers = Customer::query();

        if (!empty($search)) {
            $customers->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone_number', 'like', '%' . $search . '%')
                    ->orWhere('area', 'like', '%' . $search . '%');
            });
        }



        $customers = $customers->paginate(10);

        return view('admin.customers.index', compact('customers', 'totalAmount', 'totalPayment', 'seasons', 'selectedSeason'));
    }

}
