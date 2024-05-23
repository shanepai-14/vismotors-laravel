<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Motor;
use Illuminate\Support\Facades\Hash;
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
    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Get the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists and the password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401); // Unauthorized
        }

        // Generate and return the API token
        $token = $user->createToken('auth_token')->plainTextToken;

        $profile = collect([$user->profile])->map(function ($profile) {
            return [
                'id' => $profile->id,
                'user_id' => $profile->user_id,
                'profile_picture' => $profile->profile_picture,
                'gender' => optional($profile->gender)->name,
                'civil_status' => optional($profile->civil_status)->name,
                'citizenship' => optional($profile->citizenship)->name,
                'occupation' => optional($profile->occupation)->name,
                'address_brgy' => $profile->address_brgy,
                'address_city' => $profile->address_city,
                'address_prov' => $profile->address_prov,
                'address_landmark' => $profile->address_landmark,
                'address_lot' => $profile->address_lot,
                'fathers_name' => $profile->fathers_name,
                'mothers_name' => $profile->mothers_name,
                'phone_no' => $profile->phone_no,
                'date_of_birth' => $profile->date_of_birth,
                'longitude' => $profile->longitude,
                'latitude' => $profile->latitude,
                'valid_one' => $profile->valid_one,
                'valid_two' => $profile->valid_two,
                'created_at' => $profile->created_at,
                'updated_at' => $profile->updated_at,
            ];
        });

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' =>  $user,
            'profile' => $profile,
        ]);
    }
    public function getUserBalance($userId)
    {
        $user = User::findOrFail($userId);

        $transactions = $user->transactions()
            ->get()
            ->map(function ($transaction) {
                $motor = Motor::find($transaction->motors->motor_id);
                return [
                    'id' => $transaction->id,
                    'ref_no' => $transaction->ref_no,
                    'motor' => $motor->brand->name.' '.$motor->model_name.' '.$motor->model_year.' - '.$transaction->motors->color,
                    'monthly_due' => $transaction->monthly_due,
                    'created_at' => $transaction->created_at,
                    'updated_at' => $transaction->updated_at,
                    'last_balance' => $transaction->getLatestBalanceAttribute(),
                    'trans_type' => $transaction->transaction_types->name,
                    'loan' => $transaction->loan_tenure_months,
                    'status' => $transaction->statuses->name,
                    'due' => $transaction->due_date.getDaySuffix($transaction->due_date),
                    // 'payments' => $transaction->payments->map(function ($payment) {
                    //     return [
                    //         'id' => $payment->id,
                    //         'amount' => $payment->amount,
                    //         'balance' => $payment->balance,
                    //         'created_at' => $payment->created_at,
                    //         'updated_at' => $payment->updated_at,
                    //     ];
                    // }),
                ];
            });
            if ($transactions->isEmpty()) {
                return response()->json([
                    'message' => 'No transactions found for the user.'
                ], 404);
            }
        return response()->json($transactions);
    }
    public function getUserPayments($userId)
    {
        $user = User::findOrFail($userId);

        $transactions = $user->transactions()
            ->get()
            ->map(function ($transaction) {
                $motor = Motor::find($transaction->motors->motor_id);
                // $motor->brand->name.''.$motor->modelnameyear.' - '.$transaction->motors->color
                return [
                    'id' => $transaction->id,
                    'ref_no' => $transaction->ref_no,
                    'motor' => $motor->brand->name.' '.$motor->model_name.' '.$motor->model_year.' - '.$transaction->motors->color,
                    'monthly_due' => $transaction->monthly_due,
                    'created_at' => $transaction->created_at,
                    'updated_at' => $transaction->updated_at,
                    'last_balance' => $transaction->getLatestBalanceAttribute(),
                    'payments' => $transaction->payments->map(function ($payment) {
                        return [
                            'id' => $payment->id,
                             'or_number' => $payment->or_number,
                             'payment_method' => $payment->payment_method,
                            'amount' => $payment->amount,
                            'balance' => $payment->balance,
                            'created_at' => $payment->created_at,
                            'updated_at' => $payment->updated_at,
                        ];
                    }),
                ];
            });
            if ($transactions->isEmpty()) {
                return response()->json([
                    'message' => 'No transactions found for the user.'
                ], 404);
            }
        return response()->json($transactions);
    }
}
