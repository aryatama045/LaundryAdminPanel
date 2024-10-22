<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InvoiceManage;
use Illuminate\Http\Request;

class InvoiceManageController extends Controller
{
    public function index()
    {
        $invoice = InvoiceManage::first();
        return view('invoice-manage', compact('invoice'));
    }

    public function update(Request $request, InvoiceManage $invoiceManage)
    {
        $request->validate(([
            'type' => 'required|string',
        ]));

        InvoiceManage::updateOrCreate(
            [
                'id' => $invoiceManage ? $invoiceManage->id : 0,
            ],
            [
                'type' => $request->type
            ]
        );

        return back()->with('success', 'Update Successfully');
    }
}
