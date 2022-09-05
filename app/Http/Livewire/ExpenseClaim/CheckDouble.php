<?php

namespace App\Http\Livewire\ExpenseClaim;

use Livewire\Component;
use App\Models\Expenses;
use App\Models\ExpensePeserta;

class CheckDouble extends Component
{
    protected $listeners = ['check-double'=>'$refresh','reload-double'=>'$refresh'];
    public function render()
    {
        $data = Expenses::select('expenses.*')
                            ->with(['pesertas','bank_books','bank_books.bank_books'])
                            ->orderBy('expenses.id','desc')->where('expenses.reference_type','Claim')->groupBy('expenses.id')
                            ->leftJoin('expense_pesertas','expense_pesertas.expense_id','=','expenses.id')
                            ->leftJoin('policys','policys.id','=','expenses.policy_id')
                            ->where('is_double',1);

        return view('livewire.expense-claim.check-double')->with(['data'=>$data->get()]);
    }

    public function keep(Expenses $id)
    {
        $id->is_double = 0;
        $id->save();

        $this->emit('reload-double');
    }

    public function delete(Expenses $id)
    {
        ExpensePeserta::where('expense_id',$id->id)->delete();
        $id->delete();

        $this->emit('reload-double');
    }

    public function deleteAll()
    {
        Expenses::where('is_double',1)->delete();

        session()->flash('message-success',__('Claim Delete All'));
        
        \LogActivity::add("Expense Claim Delete All");

        return redirect()->route('expense.claim');
    }

    public function keepAll()
    {
        Expenses::where('is_double',1)->update(['is_double'=>0]);

        session()->flash('message-success',__('Claim Dekete All'));
        
        \LogActivity::add("Expense Claim Delete All");

        return redirect()->route('expense.claim');
    }
}
