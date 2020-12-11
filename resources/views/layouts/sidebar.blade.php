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
                                {{-- <li class="{{ Request::segment(1) === 'coa-type' ? 'active' : null }}"><a href="{{route('coa-type')}}">COA Types</a></li> --}}
                            </ul>
                        </li>
                        @endif
                        @if(\Auth::user()->user_access_id==2)<!--Finance-->     
                        <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                            <a href="/"><i class="icon-home"></i> <span>Dashboard</span></a>
                        </li>
                        <li class="{{ (Request::segment(1) === 'konven' || Request::segment(1) === 'syariah') ? 'active' : null }}">
                            <a href="#" class="has-arrow"><i class="fa fa-database"></i> <span>Teknis</span></a>
                            <ul>
                                <li class="{{ Request::segment(1) === 'konven' ? 'active' : null }}"><a href="{{route('konven')}}"><i class="fa fa-list-alt"></i> Konven</a></li>
                                <li class="{{ Request::segment(1) === 'syariah' ? 'active' : null }}"><a href="{{route('syariah')}}"><i class="fa fa-list-alt"></i> Syariah</a></li>        
                            </ul>
                        </li>
                        <li class="{{ (Request::segment(1) === 'operation') ? 'active' : null }}">
                            <a href="{{route('operation')}}"><i class="fa fa-database"></i> <span>Operation</span></a>
                        </li>  
                        @endif
                        @if(\Auth::user()->user_access_id==3)<!--Accounting-->     
                        <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                            <a href="/"><i class="icon-home"></i> <span>Dashboard</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'income' ? 'active' : null }}">
                            <a href="{{route('income')}}"><i class="fa fa-database"></i> <span>Income </span><span class="float-right badge badge-danger">{{\App\Models\Income::where('status',1)->count()}}</span></a>
                        </li>
                        <li class="{{ Request::segment(1) === 'expense' ? 'active' : null }}">
                            <a href="{{route('expense')}}"><i class="fa fa-database"></i> <span>Expense</span><span class="float-right badge badge-danger">{{\App\Models\Expenses::where('status',1)->count()}}</span></a>
                        </li>
                        @endif
                        @if(\Auth::user()->user_access_id==4)<!--Treasury-->     
                        <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                            <a href="{{route('treasury.index')}}"><i class="icon-home"></i> <span>Dashboard</span></a>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>        
        </div>          
    </div>
</div>