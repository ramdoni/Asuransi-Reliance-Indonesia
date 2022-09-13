@section('title', __('Treasury'))
@section('parentPageTitle', __('Summary'))
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="row">
                    <div class="col-md-2" wire:ignore>
                        <select class="form-control" wire:model="filter_year">
                            <option value=""> -- Year -- </option>
                            @foreach($years as $item)
                                <option>{{$item->year}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" wire:model="filter_month">
                            <option value=""> -- Month -- </option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <span wire:loading>
                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                            <span class="sr-only">{{ __('Loading...') }}</span>
                        </span>
                    </div>
                </div>
                <br />  
                <div class="table-responsive">
                    <table class="table hovered m-b-0 c_list" id="data_table">
                        <thead>
                            <tr style="background:#eee">
                                <th>Bank</th>
                                @foreach($summary as $item)
                                    <th class="text-right">{{date('d/m/Y',strtotime($item->date_summary))}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bank as $item)
                                <tr>
                                    <td>{{$item->no_rekening}} {{$item->bank}} - {{$item->owner}}</td>
                                    @foreach($summary as $sum)
                                        <td class="text-right">
                                            @php($amount=$item->summary->where('date_summary',$sum->date_summary)->first())
                                            @if($amount)
                                               {{format_idr($amount->amount)}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>