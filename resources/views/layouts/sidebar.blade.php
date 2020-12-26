<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">
        <div class="user-account">
            @if(\Auth::user()->profile_photo_path!="")
            <img src="{{ \Auth::user()->profile_photo_path }}" class="rounded-circle user-photo" alt="User Profile Picture">
            @endif
            <div class="dropdown">
                <span>Welcome,</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{ isset(\Auth::user()->name)?\Auth::user()->name :''}}</strong></a>
                <ul class="dropdown-menu dropdown-menu-right account">
                    <li><a href="{{route('profile')}}"><i class="icon-user"></i>My Profile</a></li>
                    <li><a href=""><i class="icon-envelope-open"></i>Messages</a></li>
                    <li><a href="{{route('setting')}}"><i class="icon-settings"></i>Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="#" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="icon-power"></i>Logout</a></li>
                </ul>
            </div>
            <hr>
            <ul class="row list-unstyled">
                <li class="col-6">
                    <small>Receivable</small>
                    <h6>{{format_idr(\App\Models\Income::where('status',3)->whereYear('created_at',date('Y'))->sum('nominal'))}}</h6>
                </li>
                <li class="col-6">
                    <small>Payable</small>
                    <h6>{{format_idr(\App\Models\Expenses::where('status',3)->whereYear('created_at',date('Y'))->sum('nominal'))}}</h6>
                </li>
            </ul>
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu"><i class="fa fa-database"></i> Data</a></li>    
        </ul>
        <!-- Tab panes -->
        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane active" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">    
                        @if(\Auth::user()->user_access_id==1)<!--Administrator-->                   
                        <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                            <a href="/"><i class="fa fa-home"></i> <span>Dashboard</span></a>
                        </li>
                        <li class="{{ (Request::segment(1) === 'konven-underwriting' || Request::segment(1) === 'konven-reinsurance'  || Request::segment(1) === 'konven-claim') ? 'active' : null }}">
                            <a href="#App" class="has-arrow"><i class="fa fa-database"></i> <span>Konven</span></a>
                            <ul>
                                <li class="{{ Request::segment(1) === 'konven-underwriting' ? 'active' : null }}"><a href="{{route('konven.underwriting')}}">Underwriting</a></li>
                                <li class="{{ Request::segment(1) === 'konven-reinsurance' ? 'active' : null }}"><a href="{{route('konven.reinsurance')}}">Reinsurance</a></li>
                                <li class="{{ Request::segment(1) === 'konven-claim' ? 'active' : null }}"><a href="{{route('konven.claim')}}">Claim</a></li>
                            </ul>
                        </li>
                        <li class="{{ (Request::segment(1) === 'syariah-underwriting') ? 'active' : null }}">
                            <a href="#App" class="has-arrow"><i class="fa fa-database"></i> <span>Syariah</span></a>
                            <ul>
                                <li class="{{ Request::segment(1) === 'coa' ? 'active' : null }}"><a href="{{route('coa')}}">Underwriting</a></li>
                                <li class="{{ Request::segment(1) === 'coa-group' ? 'active' : null }}"><a href="{{route('coa-group')}}">Reinsurance</a></li>
                                <li class="{{ Request::segment(1) === 'coa-group' ? 'active' : null }}"><a href="">Claim</a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::segment(1) === 'users' ? 'active' : null }}">
                            <a href="{{route('users.index')}}"><i class="fa fa-users"></i> <span>Users</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'sales-tax' ? 'active' : null }}">
                            <a href="{{route('sales-tax')}}"><i class="fa fa-database"></i> <span>Sales Tax</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'policy' ? 'active' : null }}">
                            <a href="{{route('policy')}}"><i class="fa fa-database"></i> <span>Polis</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'journal' ? 'active' : null }}">
                            <a href="{{route('bank-account')}}"><i class="fa fa-database"></i> <span>Bank Account</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'code-cashflow' ? 'active' : null }}">
                            <a href="{{route('code-cashflow')}}"><i class="fa fa-database"></i> <span>Code Cashflow</span></a>
                        </li>
                        <li class="{{ (Request::segment(1) === 'coa' || Request::segment(1) === 'coa-group' || Request::segment(1) === 'coa-type') ? 'active' : null }}">
                            <a href="#App" class="has-arrow"><i class="fa fa-database"></i> <span>COA</span></a>
                            <ul>
                                <li class="{{ Request::segment(1) === 'coa' ? 'active' : null }}"><a href="{{route('coa')}}">COA</a></li>
                                <li class="{{ Request::segment(1) === 'coa-group' ? 'active' : null }}"><a href="{{route('coa-group')}}">COA Groups</a></li>
                            </ul>
                        </li>
                        @endif
                        @if(\Auth::user()->user_access_id==2)<!--Finance-->     
                        <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                            <a href="/"><i class="fa fa-home"></i> <span>Dashboard</span></a>
                        </li>
                        <li class="{{ (Request::segment(1) === 'income-premium-receivable' || Request::segment(1) === 'income-reinsurance' ||  Request::segment(1) ==='income-investment') ? 'active' : null }}">
                            <a href="#" class="has-arrow"><i class="fa fa-database"></i> <span>Income</span></a>
                            <ul>
                                <li class="{{ Request::segment(1) === 'income-premium-receivable' ? 'active' : null }}"><a href="{{route('income.premium-receivable')}}"> Premium Receivable</a></li>
                                <li class="{{ Request::segment(1) === 'income-reinsurance' ? 'active' : null }}"><a href="{{route('income.reinsurance')}}"> Reinsurance Commision</a></li>        
                                <li class="{{ Request::segment(1) === 'income-recovery-claim' ? 'active' : null }}"><a href="#"> Recovery Claim</a></li>        
                                <li class="{{ Request::segment(1) === 'income-investment' ? 'active' : null }}"><a href="{{route('income.investment')}}"> Invesment</a></li>        
                            </ul>
                        </li>
                        <li class="{{ (Request::segment(1) === 'expense-claim' || Request::segment(1) === 'expense-others' || Request::segment(1) === 'expense-reinsurance-premium' || Request::segment(1) === 'expense-commision-payable') ? 'active' : null }}">
                            <a href="#" class="has-arrow"><i class="fa fa-database"></i> <span>Expense</span></a>
                            <ul>
                                <li class="{{ Request::segment(1) === 'expense-reinsurance-premium' ? 'active' : null }}">
                                    <a href="{{route('expense.reinsurance-premium')}}"> Reinsurance Premium</a>
                                </li>
                                <li class="{{ Request::segment(1) === 'expense-endorsement' ? 'active' : null }}"><a href="{{route('expense.commision-payable')}}"> Endorsement</a></li>
                                <li class="{{ Request::segment(1) === 'expense-cancelation' ? 'active' : null }}"><a href="{{route('expense.cancelation')}}"> Cancelation</a></li>
                                <li class="{{ Request::segment(1) === 'expense-refund' ? 'active' : null }}"><a href="{{route('expense.refund')}}"> Refund</a></li>
                                <li class="{{ Request::segment(1) === 'expense-claim' ? 'active' : null }}"><a href="{{route('expense.claim')}}"> Claim Payable</a></li>
                                <li class="{{ Request::segment(1) === 'expense-others' ? 'active' : null }}"><a href="{{route('expense.others')}}"> Others Expense</a></li>        
                            </ul>
                        </li>
                        @endif
                        @if(\Auth::user()->user_access_id==3)<!--Accounting-->     
                        <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                            <a href="{{route('accounting-journal.index')}}"><i class="fa fa-home"></i> <span>Journal</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                            <a href="/"><i class="fa fa-database"></i> <span>Cashflow</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                            <a href="/"><i class="fa fa-database"></i> <span>Trial Balance</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                            <a href="/"><i class="fa fa-database"></i> <span>Income Statement</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                            <a href="/"><i class="fa fa-database"></i> <span>Balance Sheet</span></a>
                        </li>
                        @endif
                        @if(\Auth::user()->user_access_id==4)<!--Treasury-->     
                        <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                            <a href="{{route('treasury.index')}}"><i class="fa fa-home"></i> <span>Dashboard</span></a>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>        
        </div>          
    </div>
</div>