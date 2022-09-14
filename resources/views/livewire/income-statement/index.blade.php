@section('title', 'Accounting')
@section('parentPageTitle', 'Income Statement')
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header row">
                <div class="col-md-1">
                    <select class="form-control" wire:model="tahun">
                        <option value=""> -- Year -- </option>
                        @foreach(\App\Models\IncomeStatement::groupBy('tahun')->get() as $i)
                            @if($i->tahun=="") @continue @endif
                            <option>{{$i->tahun}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <span wire:loading>
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span class="sr-only">{{ __('Loading...') }}</span>
                    </span>
                </div>
            </div>
            <div class="pt-0 body">
                <div class="table-responsive">
                    <table class="table  m-b-0 c_list">
                        <tbody>
                            <tr style="background: #eee;">
                                <th>Keterangan</th>
                                @foreach($period as $item)
                                    <th class="text-right">{{date('M', mktime(0, 0, 0, $item->bulan, 10))}}-{{$tahun}}</th>
                                @endforeach
                            </tr>
                            @foreach($data as $group)
                                <tr>
                                    <th>{{$group->name}}</th>
                                </tr>
                                @foreach($period as $item)
                                    @php($total[$group->id][$tahun][$item->bulan] = 0)
                                @endforeach
                                @foreach($group->coa as $coa)
                                    <tr>
                                        <td style="padding-left:20px;">{{$coa->name}}</td>
                                        
                                        @foreach($period as $item)
                                            <td class="text-right">{{isset($data_arr[$tahun][$item->bulan][$coa->id])?format_idr($data_arr[$tahun][$item->bulan][$coa->id]):0}}</td>
                                            @php($total[$group->id][$tahun][$item->bulan] +=isset($data_arr[$tahun][$item->bulan][$coa->id])?$data_arr[$tahun][$item->bulan][$coa->id]:0)
                                        @endforeach
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>Total {{$group->name}}</th>
                                    @foreach($period as $item)
                                        <th class="text-right">{{@format_idr($total[$group->id][$tahun][$item->bulan])}}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br />
            </div>
        </div>
    </div>
</div>