<div class="modal-dialog" style="min-width: 95%;" role="document">
    <div class="modal-content">
        <form wire:submit.prevent="save">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Settle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 table-responsive">
                        <div class="form-group">
                            <table class="table table-bordered">
                                <tr style="background:#eee">
                                    <th>No</th>
                                    <th>No Voucher</th>
                                    <th>Voucher Date</th>
                                    <th>Payment Date</th>
                                    <th>Note</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                                @foreach($bank_book_id as $k => $item)
                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td>{{$item->no_voucher}}</td>
                                        <td>{{date('d-m-Y',strtotime($item->created_at))}}</td>
                                        <td>{{date('d-m-Y',strtotime($item->payment_date))}}</td>
                                        <td>{{$item->note}}</td>
                                        <td class="text-right">{{format_idr($item->amount)}}</td>
                                    </tr>
                                @endforeach
                                <tr style="background:#eee">
                                    <td></td>
                                    <td></td>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">{{format_idr($total_voucher)}}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-7 table-responsive">
                        @if($error_settle)
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <i class="fa fa-times-circle"></i> {{$error_settle}}
                            </div>
                        @endif
                        <table class="table table-bordered mb-0">
                            <tr style="background:#eee">
                                <th>No</th>
                                <th>Type</th>
                                <th>Debit Note / Kwitansi</th>
                                <th class="text-right">Amount</th>
                                <th></th>
                            </tr>
                            @foreach($payment_ids as $k => $item)
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>
                                        <select class="form-control" wire:model="types.{{$k}}">
                                            <option value="">-- select --</option>
                                            <option>Premium Receivable</option>
                                            <option>Reinsurance Commision</option>
                                            <option>Recovery Claim</option>
                                            <option>Recovery Refund</option>
                                            <option>Error Suspense Account</option>
                                            <option>Others</option>
                                            @if($this->bank_book_id->count()==1)
                                                <option>Premium Deposit</option>
                                            @endif
                                        </select>
                                        @error('type.'.$k)
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </td>
                                    <td>
                                        @if($types[$k]=='Premium Receivable')
                                            <select wire:ignore class="form-control select-premi" id="transaction_ids.{{$k}}">
                                                <option value="">-- select --</option>
                                            </select>
                                        @endif
                                        @if($types[$k]=='Reinsurance Commision')
                                            <select wire:ignore class="form-control select-reinsurance" id="transaction_ids.{{$k}}">
                                                <option value="">-- select --</option>
                                            </select>
                                        @endif
                                        @if($types[$k]=='Recovery Claim')
                                            <select wire:ignore class="form-control select-recovery-claim" id="transaction_ids.{{$k}}">
                                                <option value="">-- select --</option>
                                            </select>
                                        @endif
                                        @if($types[$k]=='Recovery Refund')
                                            <select wire:ignore class="form-control select-recovery-refund" id="transaction_ids.{{$k}}">
                                                <option value="">-- select --</option>
                                            </select>
                                        @endif
                                        @if($types[$k]=='Others')
                                            <select wire:ignore class="form-control select-others" id="transaction_ids.{{$k}}">
                                                <option value="">-- select --</option>
                                            </select>
                                        @endif
                                        @if($types[$k]=='Error Suspense Account' || $types[$k]=='Premium Deposit' )
                                            <input type="text" class="form-control" placeholder="Description" wire:model="transaction_ids.{{$k}}" />
                                        @endif
                                        <span wire:loading wire:target="types.{{$k}}">
                                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                            <span class="sr-only">Loading...</span>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        @if($types[$k]=='Premium Receivable')
                                            <input type="number" class="form-control text-right" wire:model="amounts.{{$k}}" />
                                        @endif
                                        @if($types[$k]=='Reinsurance Commision' || $types[$k]=='Recovery Claim' || $types[$k]=='Recovery Refund' || $types[$k]=='Others')
                                            {{format_idr($amounts[$k])}}
                                        @endif
                                        @if($types[$k]=='Error Suspense Account' || $types[$k]=='Premium Deposit')
                                            <input type="number" class="form-control text-right" wire:model="amounts.{{$k}}" />
                                        @endif
                                    </td>
                                    <td class="text-center"><a href="javascript:void(0)" wire:click="delete_payment({{$k}})" class="text-danger"><i class="fa fa-trash"></i></a></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="text-center">
                                    <a href="javascript:void(0)" wire:loading.remove wire:target="add_payment" wire:click="add_payment" class="mt-1"><i class="fa fa-plus"></i> Add Row</a>
                                    <span wire:loading wire:target="add_payment">
                                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                        <span class="sr-only">Loading...</span>
                                    </span>
                                </td>
                            </tr>
                            <tfoot>
                                <tr style="background:#eee">
                                    <th></th>
                                    <th></th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">{{format_idr($total_payment)}}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span wire:loading wire:target="save">
                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                    <span class="sr-only">{{ __('Loading...') }}</span>
                </span>
                <a href="#" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
                @if($total_payment!=0)
                    {{-- <a href="#" wire:click="onhold" class="btn btn-warning"><i class="fa fa-bookmark"></i> On Hold</a> --}}
                @endif
                @if($total_voucher==$total_payment)
                    <button type="submit" class="btn btn-primary ml-4"><i class="fa fa-save"></i> Submit</button>
                @endif
            </div>
        </form>
    </div>
</div>
@push('after-scripts')
    <script>
        var select_premi,select_reinsurance,recovery_claim,recovery_refund,select_others;
        Livewire.on('select-type',()=>{
            select_premi = $('.select-premi').select2({
                placeholder: " -- select -- ",
                ajax: {
                    url: '{{route('ajax.get-premium-receivable')}}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.reference_no + " - " + item.client+" - "+ item.nominal,
                                id: item.id
                            }
                        })
                    };
                    },
                    cache: true
                }
            });
            $('.select-premi').on('change', function (e) {
                let elementName = $(this).attr('id');
                var data = $(this).select2("val");
                @this.set(elementName, data);
            });


            // select reinsurance
            select_reinsurance = $('.select-reinsurance').select2({
                placeholder: " -- select -- ",
                ajax: {
                    url: '{{route('ajax.get-reinsurance')}}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.reference_no + " - " + item.client +" / Rp. "+item.nominal,
                                id: item.id
                            }
                        })
                    };
                    },
                    cache: true
                }
            });
            $('.select-reinsurance').on('change', function (e) {
                let elementName = $(this).attr('id');
                var data = $(this).select2("val");
                @this.set(elementName, data);
            });

            // select recovery claim
            select_recovery_claim = $('.select-recovery-claim').select2({
                placeholder: " -- select -- ",
                ajax: {
                    url: '{{route('ajax.get-recovery-claim')}}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.reference_no + " - " + item.client +" / Rp. "+item.nominal,
                                id: item.id
                            }
                        })
                    };
                    },
                    cache: true
                }
            });
            $('.select-recovery-claim').on('change', function (e) {
                let elementName = $(this).attr('id');
                var data = $(this).select2("val");
                @this.set(elementName, data);
            });

            // select others
            select_others = $('.select-others').select2({
                placeholder: " -- select -- ",
                ajax: {
                    url: '{{route('ajax.get-ar-others')}}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.reference_no + " / Rp. "+item.nominal,
                                id: item.id
                            }
                        })
                    };
                    },
                    cache: true
                }
            });
            
            $('.select-others').on('change', function (e) {
                let elementName = $(this).attr('id');
                var data = $(this).select2("val");
                @this.set(elementName, data);
            });
        })
    </script>
@endpush