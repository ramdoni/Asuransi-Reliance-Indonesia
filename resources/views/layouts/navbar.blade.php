<nav class="navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-btn">
            <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
        </div>
        <div class="navbar-brand">
            @if (get_setting('logo'))
                <a href="/"><img src="{{ get_setting('logo') }}" alt="Lucid Logo" class="img-responsive logo"></a>
            @endif
        </div>
        <div class="navbar-right">
            <form id="navbar-search" class="navbar-form search-form col-md-8">
                {{-- <h5 class="mt-2 ml-3 mb-0 pb-0">@yield('title')</h5>
                @if (trim($__env->yieldContent('parentPageTitle')))
                    <span class="ml-3">@yield('parentPageTitle')</span>
                @endif --}}
                <div id="navbar-menu float-left">
                    <ul class="nav navbar-nav">
                        <li><a href="" class="px-2 text-info icon-menu">Dashboard</a></li>
                        {{-- Administrator --}}
                        @if (\Auth::user()->user_access_id == 1)
                            <li class="dropdown">
                                <a href="#" class="text-info dropdown-toggle icon-menu px-1" data-toggle="dropdown">Konven</a>
                                <ul class="dropdown-menu user-menu menu-icon">
                                    <li>
                                        <a href="{{ route('konven.underwriting') }}">Underwriting</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('konven.reinsurance') }}">Reinsurance</a>
                                    </li>
                                    {{-- <li class="{{ Request::segment(1) === 'konven-claim' ? 'active' : null }}"><a href="{{route('konven.claim')}}">Claim</a></li> --}}
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="text-info dropdown-toggle icon-menu px-1" data-toggle="dropdown">Syariah</a>
                                <ul class="dropdown-menu user-menu menu-icon">
                                    <li>
                                        <a href="{{ route('syariah.underwriting') }}">Underwriting</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('syariah.reinsurance') }}">Reinsurance</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="text-info dropdown-toggle icon-menu px-1" data-toggle="dropdown">Data Master</a>
                                <ul class="dropdown-menu user-menu menu-icon">
                                    <li><a href="{{ route('users.index') }}">Users</a></li>
                                    <li><a href="{{ route('sales-tax') }}">Sales Tax</a></li>
                                    <li><a href="{{ route('policy') }}">Polis</a></li>
                                    <li><a href="{{ route('bank-account') }}">Bank Account</a></li>
                                    <li><a href="{{ route('code-cashflow') }}">Code Cashflow</a></li>
                                    <li><a href="{{ route('coa') }}">COA</a></li>
                                    <li><a href="{{ route('coa-group') }}">COA Groups</a></li>
                                    <li><a href="{{ route('log-activity') }}">Log Activity</a></li>
                                </ul>
                            </li>
                        @endif
                        
                        <!--Finance-->
                        @if (\Auth::user()->user_access_id == 2)
                            <li class="dropdown">
                                <a href="#" class="text-info dropdown-toggle icon-menu px-1" data-toggle="dropdown">Bank Book</a>
                                <ul class="dropdown-menu user-menu menu-icon">
                                    <li><a href="{{ route('bank-book.teknik') }}"> Teknik</a></li>
                                    <li
                                        class="{{ Request::segment(1) === 'bank-book-non-teknik' ? 'active' : null }}">
                                        <a href="{{ route('bank-book.non-teknik') }}"> Non Teknik</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="text-info dropdown-toggle icon-menu px-1" data-toggle="dropdown">Income</a>
                                <ul class="dropdown-menu user-menu menu-icon">
                                    <li><a href="{{ route('income.premium-receivable') }}"> Premium Receivable</a></li>
                                    <li><a href="{{ route('income.reinsurance') }}"> Reinsurance Commision</a></li>
                                    <li><a href="{{ route('income.recovery-claim') }}"> Recovery Claim</a></li>
                                    <li><a href="{{ route('income.recovery-refund') }}"> Recovery Refund</a></li>
                                    <li><a href="{{ route('income.investment') }}"> Invesment</a></li>
                                    <li><a href="{{ route('income.titipan-premi') }}"> Premium Deposit</a></li>
                                    <li><a href="{{ route('others-income.index') }}"> Others Income</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="text-info dropdown-toggle icon-menu px-1" data-toggle="dropdown">Expense</a>
                                <ul class="dropdown-menu user-menu menu-icon">
                                    <li><a href="{{ route('expense.reinsurance-premium') }}"> Reinsurance Premium</a></li>
                                    <li><a href="{{ route('expense.commision-payable') }}"> Commision Payable</a></li>
                                    <li><a href="{{ route('expense-cancelation') }}"> Cancelation</a></li>
                                    <li><a href="{{ route('expense-refund') }}"> Refund</a></li>
                                    <li><a href="{{ route('expense.claim') }}"> Claim Payable</a></li>
                                    <li><a href="{{ route('expense.others') }}"> Others Expense</a></li>
                                    <li><a href="{{ route('expense-handling-fee') }}"> Handling Fee</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('endorsement.index') }}" class="text-info">Endorsement</a></li>
                        @endif

                        @if (\Auth::user()->user_access_id == 3)
                            <!--Accounting-->
                            <li><a href="{{ route('accounting-journal.index') }}" class="text-info px-1 "> Journal </a></li>
                            <li><a href="{{ route('journal-penyesuaian.index') }}" class="text-info px-1 "> Adjusting </a></li>
                            <li><a href="{{ route('general-ledger.index') }}" class="text-info px-1"> General Ledger </a></li>
                            <li><a href="{{route('cashflow.index')}}" class="text-info px-1"> Cashflow </a></li>
                            <li><a href="{{route('trial-balance.index')}}" class="text-info px-1"> Trial Balance </a></li>
                            <li><a href="#" class="text-info px-1"> Income Statement </a></li>
                            <li><a href="#" class="text-info px-1"> Balance Sheet </a></li>
                        @endif
                        @if (\Auth::user()->user_access_id == 4)
                            <!--Treasury-->
                            <li><a href="{{ route('bank-book.index') }}" class="text-info px-1">Bank Book</a></li>
                            <li><a href="{{ route('inhouse-transfer.index') }}" class="text-info px-1">Inhouse Transfer</span></a></li>
                            <li><a href="{{ route('bank-account-company') }}" class="text-info px-1">Bank Account</span></a></li>
                            <li class="dropdown">
                                <a href="#" class="text-info dropdown-toggle icon-menu px-1" data-toggle="dropdown">Expense</a>
                                <ul class="dropdown-menu user-menu menu-icon">
                                    <li><a href="{{ route('expense.reinsurance-premium') }}"> Reinsurance Premium</a></li>
                                    <li><a href="{{ route('expense.commision-payable') }}"> Commision Payable</a></li>
                                    <li><a href="{{ route('expense-cancelation') }}"> Cancelation</a></li>
                                    <li><a href="{{ route('expense-refund') }}"> Refund</a></li>
                                    <li class="{{ Request::segment(1) === 'expense-claim' ? 'active' : null }}"><a
                                            href="{{ route('expense.claim') }}"> Claim Payable</a></li>
                                    <li class="{{ Request::segment(1) === 'expense-others' ? 'active' : null }}"><a
                                            href="{{ route('expense.others') }}"> Others Expense</a></li>
                                    <li
                                        class="{{ Request::segment(1) === 'expense-handling-fee' ? 'active' : null }}">
                                        <a href="{{ route('expense-handling-fee') }}"> Handling Fee</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (\Auth::user()->user_access_id == 5)
                            <!--Teknis-->
                            <li class="dropdown">
                                <a href="#" class="text-info dropdown-toggle icon-menu px-1" data-toggle="dropdown">Konven</a>
                                <ul class="dropdown-menu user-menu menu-icon">
                                    <li>
                                        <a href="{{ route('konven.underwriting') }}">Underwriting</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('konven.reinsurance') }}">Reinsurance</a>
                                    </li>
                                </ul>
                            </li>
                            <li  class="dropdown">
                                <a href="#" class="text-info dropdown-toggle icon-menu px-1" data-toggle="dropdown">Syariah</a>
                                <ul class="dropdown-menu user-menu menu-icon">
                                    <li><a href="{{ route('syariah.underwriting') }}">Underwriting</a></li>
                                    <li><a href="{{ route('syariah.reinsurance') }}">Reinsurance</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </form>
            <div id="navbar-menu">
                <ul class="nav navbar-nav">
                    {{-- <li class="d-none d-sm-inline-block d-md-none d-lg-inline-block">
                        <a href="" class="icon-menu"><i class="fa fa-folder-open-o"></i></a>
                    </li>
                    <li class="d-none d-sm-inline-block d-md-none d-lg-inline-block">
                        <a href="" class="icon-menu"><i class="icon-calendar"></i></a>
                    </li>
                    <li class="d-none d-sm-inline-block">
                        <a href="" class="icon-menu"><i class="icon-bubbles"></i></a>
                    </li>
                    <li class="d-none d-sm-inline-block">
                        <a href="" class="icon-menu"><i class="icon-envelope"></i><span class="notification-dot"></span></a>
                    </li> --}}
                    {{-- <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                            <i class="icon-bell"></i>
                            <span class="notification-dot"></span>
                        </a>
                        <ul class="dropdown-menu notifications">
                            <li class="header"><strong>You have 0 new Notifications</strong></li>
                            <li class="footer"><a href="javascript:void(0);" class="more">See all notifications</a></li>
                        </ul>
                    </li> --}}
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown"><i
                                class="icon-equalizer"></i></a>
                        <ul class="dropdown-menu user-menu menu-icon">
                            <li class="menu-heading">ACCOUNT SETTINGS</li>
                            <li><a href="{{ route('profile') }}"><i class="icon-note"></i> <span>My Profile</span></a>
                            </li>
                            <li><a href="{{ route('setting') }}"><i class="icon-equalizer"></i>
                                    <span>Setting</span></a>
                            </li>
                            <li><a href="{{ route('back-to-admin') }}" class="text-danger"><i
                                        class="fa fa-arrow-right"></i> <span>Back to Admin</span></a></li>
                        </ul>
                    </li>
                    <li><a href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            class="icon-menu"><i class="icon-login"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
