@section('title', __('Bank Book'))
@section('parentPageTitle', __('Teknik'))
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="row mb-2">
                    <div class="col-md-1">
                        <select class="form-control" wire:model="filter_status">
                            <option value=""> - Status - </option>
                            <option value="0">Unidentity</option>
                            <option value="1">Settle</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" wire:model="filter_amount" placeholder="Amount" />
                    </div>
                    <div class="col-md-9">
                        @if($check_id)
                            <a href="javascript:void(0)" class="btn btn-info" data-toggle="modal" data-target="#modal_add"><i class="fa fa-plus"></i> Settle</a>
                        @endif
                        <span wire:loading>
                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                            <span class="sr-only">{{ __('Loading...') }}</span>
                        </span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped m-b-0 c_list">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th></th>
                                <th>Status</th>
                                <th>Voucher Number</th>
                                <th>Voucher Date</th>
                                <th class="text-center">Type</th>
                                <th>From Bank Account</th>
                                <th>Amount</th>
                                <th>Note</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($num=$data->firstItem())
                            @foreach($data as $item)
                                <tr>
                                    <td>{{$num}}</td>
                                    <td>
                                        @if($item->status==0)
                                            <div class="form-group mb-0">
                                                <label class="fancy-checkbox">
                                                    <input type="checkbox" wire:model="check_id" value="{{$item->id}}">
                                                    <span></span>
                                                </label>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->status==0)
                                            <span class="badge badge-warning">Unidentity</span>
                                        @else
                                            <span class="badge badge-success">Settle</span>
                                        @endif
                                    </td>
                                    <td>{{$item->no_voucher}}</td>
                                    <td>{{date('d-m-Y',strtotime($item->created_at))}}</td>
                                    <td class="text-center">{{$item->type}}</td>
                                    <td>{{isset($item->to_bank->no_rekening) ? $item->to_bank->no_rekening .'- '.$item->to_bank->bank.' an '. $item->to_bank->owner : '-'}}</td>
                                    <td>{{format_idr($item->amount)}}</td>
                                    <td>{{$item->note}}</td>
                                    <td></td>
                                </tr>
                                @php($num++)
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        @livewire('bank-book.insert-settle')
    </div>
    @push('after-scripts')
        <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}"/>
        <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
        <style>
            .select2-container .select2-selection--single {height:36px;padding-left:10px;}
            .select2-container .select2-selection--single .select2-selection__rendered{padding-top:3px;}
            .select2-container--default .select2-selection--single .select2-selection__arrow{top:4px;right:10px;}
            .select2-container {width: 100% !important;}
        </style>
        <script>
            select__2 = $('#select-premi').select2();
            $('#select-premi').on('change', function (e) {
                let elementName = $(this).attr('id');
                var data = $(this).select2("val");
                @this.set(elementName, data);
            });
            var selected__ = $('#select-premi').find(':selected').val();
            if(selected__ !="") select__2.val(selected__);
        </script>
    @endpush

</div>