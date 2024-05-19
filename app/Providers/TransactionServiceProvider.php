<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Transaction;
use App\Models\TransactionPayment;
class TransactionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Transaction::creating(function ($model) {
            $model->ref_no = $this->generateUniqueContractNumber();
   
        });
        TransactionPayment::creating(function ($model) {

            $model->or_number = $this->generateOR();
        });
    }

    /**
     * Generate a unique contract number.
     *
     * @return string
     */
    protected function generateUniqueContractNumber()
    {
        $lastTransaction = Transaction::latest('created_at')->first();
        $lastContractNumber = $lastTransaction ? $lastTransaction->ref_no : 0;

        do {
            $contractNumber = str_pad(++$lastContractNumber, 6, '0', STR_PAD_LEFT);
            $contractNumberExists = Transaction::where('ref_no', $contractNumber)->exists();
        } while ($contractNumberExists);

        return $contractNumber;
    }

     /**
     * Generate a unique or.
     *
     * @return string
     */
    protected function generateOR()
    {
        // Get the latest receipt number from the database
        $lastReceipt = TransactionPayment::latest('id')->first();

        // Extract the numeric part of the last receipt number
        $lastNumber = $lastReceipt ? (int) substr($lastReceipt->or_number, -6) : 0;

        // Increment the number for the new receipt
        $newNumber = $lastNumber + 1;

        // Pad the number to ensure it is 6 digits long
        $newReceiptNumber = 'OR' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);

        return $newReceiptNumber;
    }
}
