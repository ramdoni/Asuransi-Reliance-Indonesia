<?php

namespace App\Http\Livewire\ExpenseClaim;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\KonvenClaim;
use App\Models\Expenses;
use App\Models\ExpensePeserta;
use App\Models\Policy;
use App\Models\Journal;

class Upload extends Component
{
    use WithFileUploads;
    public $file,$line_bussines,$type_data=1;
    public function render()
    {
        return view('livewire.expense-claim.upload');
    }

    public function save()
    {
        $this->validate([
            'file'=>'required|mimes:xls,xlsx|max:51200', // 50MB maksimal
            'line_bussines'=>'required'
        ]);
        
        $path = $this->file->getRealPath();
       
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $data = $reader->load($path);
        $sheetData = $data->getActiveSheet()->toArray();
        
        if(count($sheetData) > 0){
            $countDouble = 1;
            foreach(Expenses::where('is_double',1)->get() as $ex){
                ExpensePeserta::where('expense_id',$ex->id)->delete();
                $ex->delete();
            }
            
            foreach($sheetData as $key => $i){
                if($key<1) continue; // skip header
                
                foreach($i as $k=>$a){$i[$k] = trim($a);}
                
                $nomor_polis = $i[0];
                $nama_pemegang = $i[1];
                $nomor_partisipan = $i[2];
                $nama_partisipan = $i[3];
                $nilai_klaim = $i[4];
                $or = $i[5];
                $reas = $i[6];
                $status = $i[7];

                if(empty($nomor_polis)) continue;
                $policy = Policy::where('no_polis',$nomor_polis)->first();
                if(!$policy) continue;

                
                $find_polis = ExpensePeserta::where('no_peserta',$nomor_partisipan)->first();
                $is_double = 0;
                if($find_polis){
                    $countDouble++;
                    $is_double = 1;
                }
               
                $claim = new KonvenClaim();
                $claim->nomor_polis = $nomor_polis;
                $claim->nama_pemegang = $nama_pemegang;
                $claim->nomor_partisipan = $nomor_partisipan;
                $claim->nama_partisipan = $nama_partisipan;
                $claim->nilai_klaim = $nilai_klaim;
                $claim->or = $or;
                $claim->reas = $reas;
                $claim->status = $status;
                $claim->save();

                $data = new Expenses();
                $data->policy_id = isset($policy->id) ? $policy->id : 0;
                $data->reference_type = 'Claim';
                $data->recipient = $nomor_polis.' - '. $nama_pemegang;
                $data->no_voucher = generate_no_voucher_expense();
                $data->payment_amount = $nilai_klaim;
                $data->status = 4;
                $data->user_id = \Auth::user()->id;
                $data->description = $status;
                $data->transaction_id = $claim->id;
                $data->transaction_table = 'konven_claim';
                $data->is_double = $is_double;
                $data->save();
                
                $peserta = new ExpensePeserta();
                $peserta->expense_id = $data->id;
                $peserta->no_peserta = $nomor_partisipan;
                $peserta->nama_peserta = $nama_partisipan;
                $peserta->type = 1; // Claim Payable
                $peserta->policy_id = isset($policy->id) ? $policy->id : 0;
                $peserta->save();
                

                if(isset($this->line_bussines) and $this->type_data==2 and $is_double==0){
                    // generate coa
                    $no_voucher = generate_no_voucer_journal("AP");
                    
                    switch($this->line_bussines){
                        case 'DWIGUNA':
                                $coa_credit = 157;
                                $coa_debit = 259;
                                $coa_recovery = 98;
                                $coa_reas = 252;
                            break;
                        case 'JANGKAWARSA':
                                $coa_credit = 155;
                                $coa_debit = 257;
                                $coa_recovery = 96;
                                $coa_reas = 250;
                            break;
                        case 'EKAWARSA':
                                $coa_credit = 156;
                                $coa_debit = 258;
                                $coa_recovery = 97;
                                $coa_reas = 251;
                            break;
                        case 'KECELAKAAN':
                                $coa_credit = 159;
                                $coa_debit = 261;
                                $coa_recovery = 100;
                                $coa_reas = 254;
                            break;
                        default:
                                $coa_credit = 160; //Claim Payable Other Tradisional
                                $coa_debit = 262; //Claim Payable Other Tradisional
                                $coa_recovery = 101;
                                $coa_reas = 255;
                            break;
                    }

                    // journal
                    Journal::insert(['coa_id'=>$coa_debit,'no_voucher'=>$no_voucher,'date_journal'=>date('Y-m-d'),'debit'=>$nilai_klaim,'transaction_id'=>$data->id,'transaction_table'=>'expenses']);
                    Journal::insert(['coa_id'=>$coa_credit,'no_voucher'=>$no_voucher,'date_journal'=>date('Y-m-d'),'kredit'=>$nilai_klaim,'transaction_id'=>$data->id,'transaction_table'=>'expenses']);
                    
                    if($reas){
                        Journal::insert(['coa_id'=>$coa_recovery,'no_voucher'=>$no_voucher,'date_journal'=>date('Y-m-d'),'debit'=>$reas,'transaction_id'=>$data->id,'transaction_table'=>'expenses']);
                        Journal::insert(['coa_id'=>$coa_reas,'no_voucher'=>$no_voucher,'date_journal'=>date('Y-m-d'),'kredit'=>$reas,'transaction_id'=>$data->id,'transaction_table'=>'expenses']);
                    }   
                }
            }
        }

        if($countDouble!=0){
            $this->emit('modal','hide');
            $this->emit('check-double');
        }else{
            session()->flash('message-success','Upload success !');   
        
            return redirect()->route('expense.claim');
        }
    }
}