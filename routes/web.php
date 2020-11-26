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
    Route::get('module',App\Http\Livewire\Module\Index::class)->name('module.index');
    Route::get('module/insert',App\Http\Livewire\Module\Insert::class)->name('module.insert');
    Route::get('module/edit/{id}',App\Http\Livewire\Module\Edit::class)->name('module.edit');
});

// Sales and Business Development
Route::group(['middleware' => ['auth','access:2']], function(){    
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
    Route::get('bank-account',App\Http\Livewire\BankAccount\Index::class)->name('bank-account');
    Route::get('bank-account/insert',App\Http\Livewire\BankAccount\Insert::class)->name('bank-account.insert');
    Route::get('bank-account/edit/{id}',App\Http\Livewire\BankAccount\Edit::class)->name('bank-account.edit');
    Route::get('account-payable',App\Http\Livewire\AccountPayable\Index::class)->name('account-payable');
    Route::get('account-payable/insert',App\Http\Livewire\AccountPayable\Insert::class)->name('account-payable.insert');
    Route::get('account-receivable',App\Http\Livewire\AccountReceivable\Index::class)->name('account-receivable');
    Route::get('account-receivable/insert',App\Http\Livewire\AccountReceivable\Insert::class)->name('account-receivable.insert');
    Route::get('code-cashflow',App\Http\Livewire\CodeCashflow\Index::class)->name('code-cashflow');
    Route::get('code-cashflow/insert',App\Http\Livewire\CodeCashflow\Insert::class)->name('code-cashflow.insert');
    Route::get('code-cashflow/edit/{id}',App\Http\Livewire\CodeCashflow\Edit::class)->name('code-cashflow.edit');
});
