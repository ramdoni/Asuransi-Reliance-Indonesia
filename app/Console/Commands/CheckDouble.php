<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Expenses;
use App\Models\Journal;

class CheckDouble extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:double';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pengecekan data ganda, jika ditemukan data ganda maka akan di hapus datanya';

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
        $data = Expenses::where('reference_type','Claim')->groupBy('recipient')->get();
        foreach($data as $k => $item){
            echo "Recipient : {$item->recipient}\n";
            // find double
            $double = Expenses::where('recipient',$item->recipient)->where('status',4)->count();
            if($double>=2){
                echo "is double : ".$double."\n";
                $expenses = Expenses::where('recipient',$item->recipient)->where('status',4)->get();
                foreach($expenses as $expense){
                    $journal = Journal::where(['transaction_table'=>'expenses','transaction_id'=>$expense->id])->delete();
                    $expense->delete();
                    echo "deleted\n\n";
                }
            }
        }
    }
}
