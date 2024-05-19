<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
class ApiController extends Controller
{
    //



    public function getUserByContract(Request $request){
        $contractNumber = $request->input('contract');

        $transactions = Transaction::where('ref_no', $contractNumber)->first();
        if (!$transactions) {
            return response()->json(['error' => 'Contract not found'], 404);
        }

        return response()->json(['contract' => $contractNumber, 'transactions' => $transactions]);

    }
}
