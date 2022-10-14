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
            $bank_book = BankBook::select('*',\DB::raw('date(payment_date) as group_payment_date'))
            ->where(function($table)use($bank){
                $table->where('to_bank_id',$bank->id)->orWhere('from_bank_id',$bank->id);
            })->groupBy('group_payment_date')->orderBy('group_payment_date','ASC')->get();

            $saldo = $bank->open_balance_last!=0 ? $bank->open_balance_last : $bank->open_balance;
            
            echo "\n================================================\nBANK- {$bank->id} : {$bank->bank}\n";
            
            foreach($bank_book as $item){
                if($item->group_payment_date=="") continue;

                $find = BankBooksSummary::where('date_summary',$item->group_payment_date)->where('bank_account_id',$bank->id)->first();
                if($find) continue;

                $data = new BankBooksSummary();
                $data->amount_before = $saldo;

                $debit = BankBook::whereDate('payment_date',$item->group_payment_date)->where('type','R')->where('from_bank_id',$bank->id)->get()->sum('amount');
                $saldo += $debit;
                $kredit = BankBook::whereDate('payment_date',$item->group_payment_date)->where('type','P')->where('from_bank_id',$bank->id)->get()->sum('amount');
                $saldo -= $kredit;

                $data->date_summary = $item->group_payment_date;
                $data->debit = $debit;
                $data->kredit = $kredit;
                $data->bank_account_id = $bank->id;
                $data->amount = $saldo;
                $data->save();

                echo "{$item->group_payment_date},";
            }
            echo "\n";

            $bank->open_balance_last = $saldo;
            $bank->save();
        }

        return "selesai";
    }
}
