<?php

namespace App\Http\Controllers\Web\DeliveryCost;

use App\Http\Controllers\Controller;
use App\Models\DeliveryCost;
use Illuminate\Http\Request;

class DeliveryCostController extends Controller
{
    public function index()
    {
        $cost = DeliveryCost::first();
        return view('deliveryCost.index', compact('cost'));
    }

    public function updateOrCreate(Request $request)
    {
        $cost = DeliveryCost::first();
        if ($cost) {
            $cost->update([
                'cost' => $request->cost,
                'fee_cost' => $request->fee_cost,
                'minimum_cost' => $request->minimum_cost
            ]);
        }else{
            DeliveryCost::create([
                'cost' => $request->cost,
                'fee_cost' => $request->fee_cost ? $request->fee_cost : 100,
                'minimum_cost' => $request->minimum_cost ? $request->minimum_cost : 00
            ]);
        }

        return redirect()->route('deliveryCost');
    }
}
