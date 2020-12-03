<div>
    <div class="px-0 pt-0 header row">
        <div class="col-md-2">
            <select class="form-control" wire:model="year">
                <option value=""> -- Year -- </option>
                @foreach(\App\Models\Journal::select( DB::raw( 'YEAR(date_journal) AS year' ))->groupBy('year')->get() as $i)
                <option>{{$i->year}}</option>
                @endforeach
            </select>
        </div>
        <div class="px-0 col-md-4">
            <a href="javascript:void(0)" class="btn btn-info" wire:click="downloadExcel"><i class="fa fa-download"></i> Download Excel</a>
        </div>
    </div>
    <div class="px-0 table-responsive">
        <table class="table table-striped m-b-0 c_list table-bordered">
            <tbody>
                @foreach(get_group_cashflow() as $k =>$i)
                    <tr>
                        <th>{{$i}}</th>
                        <th></th>
                        @foreach(month() as $m)
                            <th>{{$k==1? $m : ''}}</th>
                        @endforeach
                    </tr>
                    @foreach(\App\Models\CodeCashflow::where('group',$k)->get() as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td style="width: 50px;">{{$item->code}}</td>
                        @foreach(month() as $m)
                            <td></td>
                        @endforeach
                    </tr>
                    @endforeach
                    
                    <!--Total-->
                    <tr>
                        <th>Cash From {{$i}}</th>
                        <th></th>
                        @foreach(month() as $m)
                            <th></th>
                        @endforeach
                    </tr>
                    <tr><td colspan="14">&nbsp;</td></tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
</div>