<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorTransaction;

class VendorTransactionController extends Controller
{
    public function update(Request $request, VendorTransaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,delivering,completed,rejected',
        ]);

        $transaction->update(['status' => strtolower($request->status)]); // Ensure status is stored in lowercase

        return redirect()->route('vendor.buyer.index')->with('success', 'Transaction status updated successfully.');
    }
}
