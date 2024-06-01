<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\MotorColorKey;
use App\Models\Transaction;
use App\Models\TransactionPayment;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        
        return view('layouts.pages.transaction.index', [
            'transactions' => $transactions
        ]);
    }

    public function create()
    {
        $customers = User::role('member')->get();
        $transaction_types = TransactionType::all();
        $motors = Motor::with('colors')->get();

        return view('layouts.pages.transaction.create', [
            'customers' => $customers,
            'transaction_types' => $transaction_types,
            'motors' => $motors
        ]);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'customer_id' => 'required',
    //         'trans_type_id' => 'required',
    //         'motor_id' => 'required',
    //         'downpayment' => 'nullable',
    //         'loan_tenure_months' => 'nullable',
    //         'due_date' => 'nullable'
    //     ]);
    //     $request['status_id'] = 1;
    //     $motor_price = MotorColorKey::whereId($request->motor_id)->with('motor')->first();
    //     if ($request->trans_type_id == 1) {
    //         $request['downpayment'] = $motor_price->price_cash;
    //         $request['loan_tenure_months'] = 0;
    //         $request['due_date'] = 0;
        
    //     } else {
    //         $remaining = $motor_price->price_installment - $request->downpayment;
    //         $payable = $remaining + ($remaining * ($motor_price->interest_rate / 100));
            
    //         $request['monthly_due'] = $payable / $request->loan_tenure_months;
     
    //     }

    //     $transaction =  Transaction::create($request->all());

    //     $request->validate([
    //         'transaction_id' => 'required',
    //         'amount' => 'required',
    //         'cashier_id' => 'required',
    //         'ref_no' => 'required',
    //         'payment_method' => 'required',
    //         'status' => 'nullable',
    //         'description' => 'nullable',
    //         'payment_plan' => 'required',
    //     ]);
         
    //     TransactionPayment::create([
    //         'transaction_id' => $transaction->id,
    //         'amount' => $transaction->downpayment,
    //         'cashier_id' => Auth::user()->id,
    //         'ref_no' => $transaction->ref_no,
    //         'payment_method' => 'Cash',
    //     ]);


    //     return redirect()->route('payment.transaction',[$transaction])->with('success', 'Data successfully saved');
    // }
    public function store(Request $request)
    {
       try{
        $request->validate([
            'customer_id' => 'required',
            'trans_type_id' => 'required',
            'motor_id' => 'required',
            'downpayment' => 'nullable|numeric',
            'loan_tenure_months' => 'nullable|integer',
            'due_date' => 'required',
            'chassis' => 'required',
        ]);
    
        $request->merge(['status_id' => 1]);
    
        $motorPriceData = MotorColorKey::whereId($request->motor_id)
            ->with('motor')
            ->firstOrFail();
            $originalQuantity = $motorPriceData->quantity;
            $motorPriceData->quantity = $originalQuantity - 1;
        if ($request->trans_type_id == 1) {
            $request->merge([
                'downpayment' => $motorPriceData->price_cash,
                'loan_tenure_months' => 0,
                'due_date' => null,
            ]);
            $remaining = 0;
        } else {
            $remaining = $motorPriceData->price_installment - $request->downpayment;
            $payable = $remaining + ($remaining * ($motorPriceData->interest_rate / 100));
            $request->merge([
                'monthly_due' => $payable / $request->loan_tenure_months,
            ]);
        }
        $motorPriceData->save();
        $transaction = Transaction::create($request->all());
    

    
      if($transaction){
        TransactionPayment::create([
            'transaction_id' => $transaction->id,
            'amount' => $transaction->downpayment,
            'cashier_id' => Auth::user()->id,
            'ref_no' => $transaction->ref_no,
            'payment_method' => 'Cash',
            'balance' =>  $remaining,
        ]);
      }
    
        return redirect()->route('payment.transaction', [$transaction])
            ->with('success', 'Data successfully saved');
       }catch (\Exception $e){
        dd($e->getMessage());
        return redirect()->back()->with('error', $e->getMessage());
       }
    }
    
 
    public function show(Transaction $transaction)
    {
        //
    }

    public function edit(Transaction $transaction)
    {
      
        $customers = User::role('member')->get();
        $transaction_types = TransactionType::all();
        $motors = Motor::with('colors')->get();

        return view('layouts.pages.transaction.create', [
            'customers' => $customers,
            'transaction_types' => $transaction_types,
            'motors' => $motors,
            'transaction' => $transaction
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'customer_id' => 'required',
            'trans_type_id' => 'required',
            'motor_id' => 'required',
            'downpayment' => 'nullable',
            'loan_tenure_months' => 'nullable'
        ]);

        $motor_selected = MotorColorKey::whereId($request->motor_id)->with('motor')->first();
        
        if ($request->trans_type_id == 1) {
            $request['downpayment'] = $motor_selected->price_cash;
            $request['loan_tenure_months'] = 0;
        } else {
            $remaining = $motor_selected->price_installment - $request->downpayment;
            $payable = $remaining + ($remaining * ($motor_selected->interest_rate / 100));

            $request['monthly_due'] = $payable / $request->loan_tenure_months;
            $request['status_id'] = 3;
        }

   
        $transaction->update($request->all());
        return redirect()->route('transaction.index')->with('success', 'Data successfully saved');
    }

    public function destroy(Transaction $transaction)
    {
        //
    }

    public function pay(Transaction $transaction)
    {
        return view('layouts.pages.transaction.pay', [
            'transactions' => $transaction
        ]);
    }
    public function paid(Request $request){
        $request->validate([
            'transaction_id' => 'required',
            'amount' => 'required',
            'cashier_id' => 'required',
            'ref_no' => 'required',
            'payment_method' => 'required',
            'status' => 'nullable',
            'description' => 'nullable',
            'payment_plan' => 'required',
            'balance' => 'required',
        ]);
        $balance = $request->balance;
        $amount = $request->amount;
        $request['balance'] =  $balance - $amount;
        $request['description'] = 'monthly';
        TransactionPayment::create($request->all());
        return redirect()->back();
    }
    public function status(Request $request) {
        $request->validate([
            'transaction_id' => 'required',
            'status_id' => 'required',
        ]);
    
        $transaction = Transaction::find($request->transaction_id);
        
        if ($transaction) {
            $transaction->status_id = $request->status_id;
            $transaction->save();
            return redirect()->back()->with('success', 'Data successfully saved');
        }
    
        return redirect()->back()->with('error', 'Transaction not found');
    }
    public function monthly_report(Request $request){
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        // Fetch payments for the selected month
        $payments = TransactionPayment::whereYear('created_at', '=', Carbon::parse($month)->year)
                           ->whereMonth('created_at', '=', Carbon::parse($month)->month)
                           ->get();
                
                           $data = [];
                           foreach ($payments as $payment) {
                            $data[] = [
                                'contract' => $payment->ref_no,
                                'or_number' => $payment->or_number,
                                'amount' =>'₱'.number_format($payment->amount,2, '.', ',') ,
                                'payment_method' => $payment->payment_method,
                                'cashier' => $payment->cashier->first_name ." ". $payment->cashier->last_name,
                                'date' => $payment->created_at->format('M d, Y'),
                                'balance' => '₱'.number_format(isset($payment->balance) ? $payment->balance : 0,2, '.', ','),
                            ];
                        }
                    
                        $response = [
                            'draw' => (int) $request->input('draw'),
                            'recordsTotal' => $payments->count(),
                            'recordsFiltered' => $payments->count(),
                            'data' => $data,
                        ];
                    
                        return response()->json($response);


    } 

    public function report_index(){
        
        return view('layouts.pages.report.report');
    }

   
}
