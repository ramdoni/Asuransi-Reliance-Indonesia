@section('title', __('Treasury'))
@section('parentPageTitle', __('Summary'))
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="row">
                    <div class="col-md-2">
                        <select class="form-control">
                            <option value=""> -- Year -- </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control">
                            <option value=""> -- Month -- </option>
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
                                    <th>{{$item->date_summary}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($summary as $item)
                                <tr>
                                    <td>{{isset($item->bank->owner) ? $item->bank->owner : '-'}}</td>
                                    <td>{{format_idr($item->amount)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>