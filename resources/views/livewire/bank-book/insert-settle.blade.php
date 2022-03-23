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
                    <div class="col-md-5">
                        <div class="form-group">
                            <table class="table table-bordered">
                                <tr style="background:#eee">
                                    <th>No</th>
                                    <th>No Voucher</th>
                                    <th>Voucher Date</th>
                                    <th>Note</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                                @foreach($bank_book_id as $k => $item)
                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td>{{$item->no_voucher}}</td>
                                        <td>{{date('d-m-Y',strtotime($item->created_at))}}</td>
                                        <td>{{$item->note}}</td>
                                        <td class="text-right">{{format_idr($item->amount)}}</td>
                                    </tr>
                                    @php($total_voucher +=$item->amount)
                                @endforeach
                                <tr style="background:#eee">
                                    <td></td>
                                    <td></td>
                                    <th></th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">{{format_idr($total_voucher)}}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-7">
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
                                            <option>Reinsurance Premium</option>
                                            <option>Recovery Claim</option>
                                            <option>Recovery Refund</option>
                                            <option>Error Suspense Account</option>
                                        </select>
                                        @error('type.'.$k)
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </td>
                                    <td>
                                        <span wire:loading wire:target="types.{{$k}}">
                                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                            <span class="sr-only">Loading...</span>
                                        </span>
                                        @if($types[$k]=='Premium Receivable')
                                            <select wire:ignore class="form-control select-premi" id="transaction_ids.{{$k}}">
                                                <option value="">-- select --</option>
                                            </select>
                                        @endif
                                        @if($types[$k]=='Reinsurance Premium')
                                            <select wire:ignore class="form-control select-reinsurance" id="transaction_ids.{{$k}}">
                                                <option value="">-- select --</option>
                                            </select>
                                        @endif
                                        @if($types[$k]=='Error Suspense Account')
                                            <input type="text" class="form-control" placeholder="Description" wire:model="transaction_ids.{{$k}}" />
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if($types[$k]=='Premium Receivable' || $types[$k]=='Reinsurance Premium')
                                            @php($premi = \App\Models\Income::find($transaction_ids[$k]))
                                            @if($premi)
                                                {{format_idr($premi->nominal)}}
                                                @php($amounts[$k] = $premi->nominal)
                                                @php($total_payment += $premi->nominal) 
                                            @endif
                                        @endif
                                        @if($types[$k]=='Error Suspense Account')
                                            <input type="number" class="form-control text-right" wire:model="amounts.{{$k}}" />
                                            @php($total_payment += $amounts[$k]==""?0:$amounts[$k])
                                        @endif
                                    </td>
                                    <td class="text-center"><a href="javascript:void(0)" wire:click="delete_payment({{$k}})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
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
                <a href="#" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</a>
                {{-- <button type="submit" class="btn btn-primary btn-sm ml-4"><i class="fa fa-save"></i> Submit</button> --}}

                @if($total_voucher==$total_payment)
                    <button type="submit" class="btn btn-primary btn-sm ml-4"><i class="fa fa-save"></i> Submit</button>
                @endif
            </div>
        </form>
    </div>
</div>
@push('after-scripts')
    <script>
        var select_premi,select_reinsurance;
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
                                text: item.reference_no + " - " + item.client,
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
        })
    </script>
@endpush