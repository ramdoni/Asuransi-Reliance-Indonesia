<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Journal;
use App\Models\KonvenUnderwriting;

class CheckJournal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-journal';

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
        $journal = Journal::where('coa_id',78)->get();
        foreach($journal as $item){
            if($item->transaction_table=='konven_underwriting'){
                $uw = KonvenUnderwriting::find($item->transaction_id);
                if($uw){
                    if($uw->line_bussines=='JANGKAWARSA'){
                        $item->coa_id = 73;
                        $item->save();
                        echo "Change Item : {$item->no_voucher}\n";
                    }
                }
            }
        }
    }
}
