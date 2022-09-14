<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Journal;
use App\Models\IncomeStatement;
use App\Models\Coa;

class GenerateIncomeStatement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:income-statement';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Income statement monthly';

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
        $j = Journal::select(\DB::raw('YEAR(created_at) tahun, MONTH(created_at) bulan'),'coa_id')->groupBy('tahun','bulan','coa_id')->get();
        foreach($j as $item){
            
            if($item->tahun=="" || $item->bulan==="" || $item->coa_id=="") continue;

            $sum = Journal::select(\DB::raw('SUM(kredit) total_kredit,SUM(debit) total_debit'))->whereYear('created_at','=',$item->tahun)->whereMonth('created_at','=',$item->bulan)->where('coa_id',$item->coa_id)->first();
            $coa = Coa::find($item->coa_id);

            $saldo = $item->opening_balance_last ? $item->opening_balance_last : $item->opening_balance;

            $saldo += $sum->total_debit;
            $saldo -= $sum->total_kredit;

            $coa->opening_balance_last = $saldo;
            $coa->save();

            echo "Tahun {$item->tahun} bulan {$item->bulan}, coa_id :  {$item->coa_id}\n"; 
            echo "Debit {$sum->total_debit}\n";
            echo "Kredit {$sum->total_kredit}\n=========================================\n\n";

            $data = IncomeStatement::where(['tahun'=>$item->tahun,'bulan'=>$item->bulan,'coa_id'=>$item->coa_id])->first();
            if(!$data) $data = new IncomeStatement();

            $data->coa_id = $item->coa_id;
            $data->tahun = $item->tahun;
            $data->bulan = $item->bulan;
            $data->amount = $saldo;
            $data->save();
        }
    }
}
