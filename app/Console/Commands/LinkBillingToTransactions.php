<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Diji\Billing\Models\Invoice;
use Diji\Billing\Models\Transaction;
use Illuminate\Console\Command;

class LinkBillingToTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:link-to-billing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant){
            tenancy()->initialize($tenant->id);

            $transactions = Transaction::whereNull('model_id')->get();

            foreach ($transactions as $transaction){
                $invoice = Invoice::where('structured_communication', $transaction->structured_communication)->first();

                if($invoice){
                    $transaction->update([
                        'model_id' => $invoice->id,
                        'model_type' => Invoice::class
                    ]);
                }
            }
        }
    }
}
