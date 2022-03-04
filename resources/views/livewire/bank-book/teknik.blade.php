@section('title', __('Bank Book'))
@section('parentPageTitle', __('Teknik'))
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="row mb-2">
                    <div class="col-md-1">
                        <select class="form-control" wire:model="filter_type">
                            <option value=""> - Type - </option>
                            <option value="P">P - Payable</option>
                            {{-- <option value="R">R - Receivable</option> --}}
                            <option value="A">A - Ajust</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" wire:model="filter_amount" placeholder="Amount" />
                    </div>
                    <div class="col-md-9">
                        @if($check_id)
                            <a href="javascript:void(0)" class="btn btn-info" data-toggle="modal" data-target="#modal_add"><i class="fa fa-plus"></i></a>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-lg">
                <form wire:submit.prevent="save">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Add Teknik</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control" wire:model="type">
                                <option value="">-- select --</option>
                                <option>Premium Receivable</option>
                                <option>Reinsurance Premium</option>
                                <option>Recovery Claim</option>
                                <option>Recovery Refund</option>
                            </select>
                            @error('type')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                            @enderror
                        </div>
                        @if($type=='Premium Receivable')
                            <div class="form-group">
                                <label>Debit Note / Kwitansi</label>
                                <select class="form-control" id="select-premi">
                                    <option value="">-- select --</option>
                                    @foreach($premium_receivable as $item)
                                        <option value="{{$item->id}}">{{$item->reference_no}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <a href="#" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
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