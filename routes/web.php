<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Home;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', Home::class)->name('home')->middleware('auth');
Route::get('login', App\Http\Livewire\Login::class)->name('login');
// All login
Route::group(['middleware' => ['auth']], function(){    
    Route::get('profile',App\Http\Livewire\Profile::class)->name('profile');
    Route::get('back-to-admin',[App\Http\Controllers\IndexController::class,'backtoadmin'])->name('back-to-admin');
});
// Administrator
Route::group(['middleware' => ['auth','access:1']], function(){    
    Route::get('setting',App\Http\Livewire\Setting::class)->name('setting');
    Route::get('users/insert',App\Http\Livewire\User\Insert::class)->name('users.insert');
    Route::get('user-access', App\Http\Livewire\UserAccess\Index::class)->name('user-access.index');
    Route::get('user-access/insert', App\Http\Livewire\UserAccess\Insert::class)->name('user-access.insert');
    Route::get('users',App\Http\Livewire\User\Index::class)->name('users.index');
    Route::get('users/edit/{id}',App\Http\Livewire\User\Edit::class)->name('users.edit');
    Route::post('users/autologin/{id}',[App\Http\Livewire\User\Index::class,'autologin'])->name('users.autologin');
    Route::get('coa-group',App\Http\Livewire\CoaGroup\Index::class)->name('coa-group');
    Route::get('coa-group/insert',App\Http\Livewire\CoaGroup\Insert::class)->name('coa-group.insert');
    Route::get('coa-group/edit/{id}',App\Http\Livewire\CoaGroup\Edit::class)->name('coa-group.edit');
    Route::get('coa',App\Http\Livewire\Coa\Index::class)->name('coa');
    Route::get('coa/insert',App\Http\Livewire\Coa\Insert::class)->name('coa.insert');
    Route::get('coa/edit/{id}',App\Http\Livewire\Coa\Edit::class)->name('coa.edit');
    Route::get('coa-type',App\Http\Livewire\CoaType\Index::class)->name('coa-type');
    Route::get('coa-type/insert',App\Http\Livewire\CoaType\Insert::class)->name('coa-type.insert');
    Route::get('coa-type/edit/{id}',App\Http\Livewire\CoaType\Edit::class)->name('coa-type.edit');
    Route::get('journal',App\Http\Livewire\Journal\Index::class)->name('journal');
    Route::get('journal/download-excel',[App\Http\Livewire\Journal\Index::class,"downloadExcel"])->name('journal.download-excel');
    Route::get('bank-account',App\Http\Livewire\BankAccount\Index::class)->name('bank-account');
    Route::get('bank-account/insert',App\Http\Livewire\BankAccount\Insert::class)->name('bank-account.insert');
    Route::get('bank-account/edit/{id}',App\Http\Livewire\BankAccount\Edit::class)->name('bank-account.edit');
    Route::get('account-payable',App\Http\Livewire\AccountPayable\Index::class)->name('account-payable');
    Route::get('account-payable/insert',App\Http\Livewire\AccountPayable\Insert::class)->name('account-payable.insert');
    Route::get('account-payable/edit/{id}',App\Http\Livewire\AccountPayable\Edit::class)->name('account-payable.edit');
    Route::get('account-payable/view/{id}',App\Http\Livewire\AccountPayable\View::class)->name('account-payable.view');
    Route::get('account-receivable',App\Http\Livewire\AccountReceivable\Index::class)->name('account-receivable');
    Route::get('account-receivable/insert',App\Http\Livewire\AccountReceivable\Insert::class)->name('account-receivable.insert');
    Route::get('account-receivable/edit/{id}',App\Http\Livewire\AccountReceivable\Edit::class)->name('account-receivable.edit');
    Route::get('account-receivable/view/{id}',App\Http\Livewire\AccountReceivable\View::class)->name('account-receivable.view');
    Route::get('code-cashflow',App\Http\Livewire\CodeCashflow\Index::class)->name('code-cashflow');
    Route::get('code-cashflow/insert',App\Http\Livewire\CodeCashflow\Insert::class)->name('code-cashflow.insert');
    Route::get('code-cashflow/edit/{id}',App\Http\Livewire\CodeCashflow\Edit::class)->name('code-cashflow.edit');
    Route::get('data-teknis',App\Http\Livewire\DataTeknis\Index::class)->name('data-teknis');
    Route::get('policy',App\Http\Livewire\Policy\Index::class)->name('policy');
    Route::get('policy/insert',App\Http\Livewire\Policy\Insert::class)->name('policy.insert');
    Route::get('sales-tax',App\Http\Livewire\SalesTax\Index::class)->name('sales-tax');
    Route::get('sales-tax/insert',App\Http\Livewire\SalesTax\Insert::class)->name('sales-tax.insert');
    Route::get('sales-tax/edit/{id}',App\Http\Livewire\SalesTax\Edit::class)->name('sales-tax.edit');
    Route::get('konven-underwriting',App\Http\Livewire\Konven\Underwriting::class)->name('konven.underwriting');
    Route::get('konven-reinsurance',App\Http\Livewire\Konven\Reinsurance::class)->name('konven.reinsurance');
    Route::get('konven-claim',App\Http\Livewire\Konven\Claim::class)->name('konven.claim');
});
// Accounting
Route::group(['middleware' => ['auth','access:3']], function(){ 
    Route::get('accounting-journal',App\Http\Livewire\AccountingJournal\Index::class)->name('accounting-journal.index');
    Route::get('accounting-journal/detail/{id}',App\Http\Livewire\AccountingJournal\Detail::class)->name('accounting-journal.detail');
    
    Route::get('income',App\Http\Livewire\Income\Index::class)->name('income');
    Route::get('income/edit/{id}',App\Http\Livewire\Income\Edit::class)->name('income.edit');
    Route::get('expense',App\Http\Livewire\Expense\Index::class)->name('expense');
    Route::get('expense/edit/{id}',App\Http\Livewire\Expense\Edit::class)->name('expense.edit');
});
// Finance
Route::group(['middleware' => ['auth','access:2']], function(){    
    Route::get('trial-balance',App\Http\Livewire\TrialBalance\Index::class)->name('trial-balance');
    Route::get('cash-flow',App\Http\Livewire\CashFlow\Index::class)->name('cash-flow');
    Route::get('income-statement',App\Http\Livewire\IncomeStatement\Index::class)->name('income-statement');
    Route::get('balance-sheet',App\Http\Livewire\BalanceSheet\Index::class)->name('balance-sheet');
    Route::get('konven',App\Http\Livewire\Konven\Index::class)->name('konven');
    Route::get('konven/underwriting/detail/{id}',App\Http\Livewire\Konven\UnderwritingDetail::class)->name('konven.underwriting.detail');
    Route::get('syariah',App\Http\Livewire\Syariah\Index::class)->name('syariah');
    Route::get('operation',App\Http\Livewire\Operation\Index::class)->name('operation');
    Route::get('operation/payable/insert',App\Http\Livewire\Operation\PayableInsert::class)->name('operation.payable.insert');
    Route::get('operation/payable/edit/{id}',App\Http\Livewire\Operation\PayableEdit::class)->name('operation.payable.edit');
    Route::get('operation/receivable/insert',App\Http\Livewire\Operation\ReceivableInsert::class)->name('operation.receivable.insert');
    Route::get('operation/receivable/edit/{id}',App\Http\Livewire\Operation\ReceivableEdit::class)->name('operation.receivable.edit');
    Route::get('operation/expense/insert',App\Http\Livewire\Operation\ExpenseInsert::class)->name('operation.expense.insert');
    Route::get('operation/expense/edit/{id}',App\Http\Livewire\Operation\ExpenseEdit::class)->name('operation.expense.edit');
    Route::get('operation/income/insert',App\Http\Livewire\Operation\IncomeInsert::class)->name('operation.income.insert');
    Route::get('operation/income/edit/{id}',App\Http\Livewire\Operation\IncomeEdit::class)->name('operation.income.edit');
    Route::get('income-premium-receivable',App\Http\Livewire\IncomePremiumReceivable\Index::class)->name('income.premium-receivable');
    Route::get('income-premium-receivable/detail/{id}',App\Http\Livewire\IncomePremiumReceivable\Detail::class)->name('income.premium-receivable.detail');
    Route::get('income-reinsurance',App\Http\Livewire\IncomeReinsurance\Index::class)->name('income.reinsurance');
    Route::get('income-reinsurance/detail/{id}',App\Http\Livewire\IncomeReinsurance\Detail::class)->name('income.reinsurance.detail');
    Route::get('income-investment',App\Http\Livewire\IncomeInvesment\Index::class)->name('income.investment');
    Route::get('expense-reinsurance-premium',App\Http\Livewire\ExpenseReinsurance\Index::class)->name('expense.reinsurance-premium');
    Route::get('expense-reinsurance-premium/detail/{id}',App\Http\Livewire\ExpenseReinsurance\Detail::class)->name('expense.reinsurance-premium.detail');
    Route::get('expense-claim',App\Http\Livewire\ExpenseClaim\Index::class)->name('expense.claim');
    Route::get('expense-claim/detail/{id}',App\Http\Livewire\ExpenseClaim\Detail::class)->name('expense.claim.detail');
    Route::get('expense-others',App\Http\Livewire\ExpenseOthers\Index::class)->name('expense.others');
    Route::get('expense-others/detail/{id}',App\Http\Livewire\ExpenseOthers\Detail::class)->name('expense.others.detail');
    Route::get('expense-others/insert',App\Http\Livewire\ExpenseOthers\Insert::class)->name('expense.others.insert');
    Route::get('expense-commision-payable',App\Http\Livewire\ExpenseCommisionPayable\Index::class)->name('expense.commision-payable');
    Route::get('expense-commision-payable/detail/{id}',App\Http\Livewire\ExpenseCommisionPayable\Detail::class)->name('expense.commision-payable.detail');
    Route::get('expense-endorsement',App\Http\Livewire\ExpenseEndorsement\Index::class)->name('expense-endorsement');
    Route::get('expense-cancelation',App\Http\Livewire\ExpenseCancelation\Index::class)->name('expense.cancelation');
    Route::get('expense-refund',App\Http\Livewire\ExpenseRefund\Index::class)->name('expense.refund');
});

// Treasury
Route::group(['middleware' => ['auth','access:4']], function(){ 
    Route::get('treasury/index',App\Http\Livewire\Treasury\Index::class)->name('treasury.index');
});