<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Income;

class CheckAging extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:aging';

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
        $claim = \App\Models\Expenses::where('expenses.reference_type','Claim')->get();
        $total =0;
        foreach($claim as $expense){
            if(isset($expense->uw->line_bussines)){
                // generate coa
                $no_voucher = generate_no_voucer_journal("AP");
                
                switch($expense->uw->line_bussines){
                    case 'DWIGUNA':
                            $coa_credit = 157;
                            $coa_debit = 259;
                        break;
                    case 'JANGKAWARSA':
                            $coa_credit = 155;
                            $coa_debit = 257;
                        break;
                    case 'EKAWARSA':
                            $coa_credit = 156;
                            $coa_debit = 258;
                        break;
                    case 'KECELAKAAN':
                            $coa_credit = 159;
                            $coa_debit = 261;
                        break;
                    default:
                            $coa_credit = 160; //Claim Payable Other Tradisional
                            $coa_debit = 262; //Claim Payable Other Tradisional
                        break;
                }
                echo "Recepient :".$expense->recipient ."\n";
                // journal
                \App\Models\Journal::insert(['coa_id'=>$coa_debit,'no_voucher'=>$no_voucher,'date_journal'=>date('Y-m-d'),'debit'=>$expense->payment_amount,'transaction_id'=>$expense->id,'transaction_table'=>'expenses']);
                \App\Models\Journal::insert(['coa_id'=>$coa_credit,'no_voucher'=>$no_voucher,'date_journal'=>date('Y-m-d'),'kredit'=>$expense->payment_amount,'transaction_id'=>$expense->id,'transaction_table'=>'expenses']);
                $total++;
            }
        }

        echo "Total : {$total}";

        // $premi  = \App\Models\Income::with('uw')->where('reference_type','Premium Receivable')->whereNull('policy_id')->get();
        // foreach($premi as $item){
        //     echo "Reference No : ".$item->reference_no ."\n";
        //     if(isset($item->uw->no_polis)){
        //         $policy = \App\Models\Policy::where('no_polis',$item->uw->no_polis)->first(); 
        //         if(!$policy){
        //             $policy = new \App\Models\Policy();
        //             $policy->no_polis = $item->uw->no_polis;
        //             $policy->pemegang_polis = $item->uw->pemegang_polis;
        //             $policy->alamat = $item->uw->alamat;
        //             $policy->cabang = $item->uw->cabang;
        //             $policy->produk = $item->uw->produk;
        //             $policy->save();
        //         }
        //         $item->policy_id = $policy->id;
        //         $item->save();
        //     }
        // }
        
        // $data = Income::orderBy('id','desc')->where(['reference_type'=>'Premium Receivable','status'=>2])->get();
        
        // foreach($data as $item){
        //     $aging = calculate_aging($item->due_date);
        //     if($aging !=0){
        //         echo "Outstanding : {$item->no_voucher}\n";
        //         $item->outstanding_balance = $item->nominal;
        //         $item->status = 3;
        //         $item->save();
        //     }
        // }

        return 0;
    }
}
