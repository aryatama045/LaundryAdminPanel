<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\StripeKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class StripeKeyUpateController extends Controller
{
    public function index()
    {
        return view('stripe-key');
    }

    public function update(Request $request, StripeKey $stripeKey)
    {
        $request->validate(([
            'public_key' => 'required|string',
            'secret_key' => 'required|string',
        ]));

        cache()->flush();

        $this->setEnv('STRIPE_KEY', $request->public_key);
        $this->setEnv('STRIPE_SECRET', $request->secret_key);

        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        return back()->with('success', 'Update Successfully');
    }
}
