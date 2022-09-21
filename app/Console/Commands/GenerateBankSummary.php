<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BankAccount;
use App\Models\BankBooksSummary;
use App\Models\BankBook;

class GenerateBankSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:bank-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach(BankAccount::where('is_client',0)->where('status',1)->get() as $bank){
            $bank_book = BankBook::select('*',\DB::raw('date(payment_date) as group_payment_date'))->where('from_bank_id',$bank->id)->groupBy('group_payment_date')->get();
            $saldo = $bank->open_balance_last ? $bank->open_balance_last : $bank->open_balance;

            // if($saldo <0) continue; // saldo kosong skip

            foreach($bank_book as $item){
                if($item->group_payment_date=="") continue;

                $find = BankBooksSummary::where('date_summary',$item->group_payment_date)->first();
                if($find) continue;

                $data = new BankBooksSummary();
                $data->amount_before = $saldo;

                $debit = BankBook::whereDate('payment_date',$item->group_payment_date)->where(['type'=>'R','from_bank_id'=>$bank->id])->sum('amount');
                $saldo += $debit;
                $kredit = BankBook::whereDate('payment_date',$item->group_payment_date)->where(['type'=>'P','from_bank_id'=>$bank->id])->sum('amount');
                $saldo -= $kredit;

                $data->date_summary = $item->group_payment_date;
                $data->debit = $debit;
                $data->kredit = $kredit;
                $data->bank_account_id = $bank->id;
                $data->amount = $saldo;
                $data->save();

                echo "Date : {$item->group_payment_date}\n";
            }

            $bank->open_balance_last = $saldo;
            $bank->save();
        }

        return "selesai";
    }
}
