@section('title', 'General Ledger')
@section('parentPageTitle', '')
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#coa">COA</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#library">Library</a></li>
                </ul>
                <div class="px-0 tab-content">
                    <div class="tab-pane show active" id="coa">
                        <div class="row">
                            <div class="col-md-3">
                                <ul class="list-unstyled m-b-0">
                                @foreach(\App\Models\Coa::orderBy('name','ASC')->offset(0)->limit(90)->get() as $coa)
                                    <li><a href="{{route('general-ledger.create',$coa->id)}}">{{$coa->name}}</a></li>
                                @endforeach
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="list-unstyled m-b-0">
                                @foreach(\App\Models\Coa::orderBy('name','ASC')->offset(90)->limit(90)->get() as $coa)
                                    <li><a href="{{route('general-ledger.create',$coa->id)}}">{{$coa->name}}</a></li>
                                @endforeach
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="list-unstyled m-b-0">
                                @foreach(\App\Models\Coa::orderBy('name','ASC')->offset(180)->limit(90)->get() as $coa)
                                    <li><a href="{{route('general-ledger.create',$coa->id)}}">{{$coa->name}}</a></li>
                                @endforeach
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="list-unstyled m-b-0">
                                @foreach(\App\Models\Coa::orderBy('name','ASC')->offset(270)->limit(90)->get() as $coa)
                                    <li><a href="{{route('general-ledger.create',$coa->id)}}">{{$coa->name}}</a></li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="library">
                        @livewire('general-ledger.library')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
