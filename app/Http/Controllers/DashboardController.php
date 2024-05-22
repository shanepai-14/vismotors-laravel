<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use App\Models\TransactionPayment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_trans = count(Transaction::all());
        $totalRevenue = TransactionPayment::totalRevenue();
        $trans = Transaction::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->orderBy('id', 'desc')->take(10)->get();
        $total_cust = count(User::role('member')->get());
        return view('dashboard', [
            'total_trans' => $total_trans,
            'total_cust' => $total_cust,
            'trans' => $trans,
            'totalRevenue' => $totalRevenue,
            
        ]);
    }
}
