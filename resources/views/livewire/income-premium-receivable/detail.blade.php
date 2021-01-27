@section('title', 'Premium Receivable '.$data->no_voucher)
@section('parentPageTitle', 'Home')
<div class="clearfix row">
    <div class="col-md-7">
        <div class="card">
            <div class="body">
                <form id="basic-form" method="post" wire:submit.prevent="save">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table pl-0 mb-0 table-striped table-nowrap">
                                <tr>
                                    <th>{{ __('Voucher Number')}}</th>
                                    <td>{{$data->no_voucher}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Voucher Date')}}</th>
                                    <td>{{date('d M Y',strtotime($data->created_at))}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Policy Number / Policy Holder')}}</th>
                                    <td>{{$data->client}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Debit Note / Kwitansi Number')}}</th>
                                    <td>
                                        <a href="#"  wire:click="$set('showDetail','underwriting')" title="Detail Debit Note / Kwitansi Number">{{$data->reference_no}}</a>
                                        @if($data->status==1)
                                            <span class="badge badge-warning" title="Handling Fee belum bisa di proses sebelum Status Premi diterima.">Unpaid</span>
                                        @endif
                                        @if($data->status==2)
                                            <span class="badge badge-success" title="Premi Paid">Paid</span>
                                        @endif
                                        @if($data->status==3)
                                            <span class="badge badge-warning" title="Outstanding">Outstanding</span>
                                        @endif
                                        @if($data->status==4)
                                            <span class="badge badge-danger" title="Premi Cancel">Cancel</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Due Date')}}</th>
                                    <td><input type="date" class="form-control col-md-6" wire:model="due_date" {{$is_readonly?'disabled':''}} /></td>
                                </tr>
                                <tr>
                                    <th>{{ __('Reference Date')}}</th>
                                    <td>{{$data->reference_date}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Premium Receivable')}}</th>
                                    <td>{{format_idr($data->nominal)}}</td>
                                </tr>
                                @if($data->endorsement->count() || $data->cancelation->count())
                                    @if($data->cancelation->count())
                                    <tr>
                                        <th>{{ __('Cancelation')}}</th>
                                        <td>
                                            @foreach($data->cancelation as $cancel)
                                            <p>{!!format_idr($cancel->nominal).' - <a href="javascript:void(0);" class="text-danger" title="Klik Detail" wire:click="showDetailCancelation('.$cancel->id.')">'.$cancel->konven_memo_pos->no_dn_cn.'</a>'!!}</p> 
                                            @endforeach
                                        </td>
                                    </tr> 
                                    <tr>
                                        <th>{{ __('Total After Cancelation')}}</th>
                                        <td>
                                            {{format_idr($data->nominal-$data->cancelation->sum('nominal'))}}
                                        </td>
                                    </tr>
                                    @endif
                                    @if($data->endorsement->count())
                                    <tr>
                                        <th>{{ __('Endorsement')}}</th>
                                        <td>
                                            @php($end_cn=0)
                                            @php($end_dn=0)
                                            @foreach($data->endorsement as $end)
                                            <p>{!!format_idr($end->nominal).' - <a href="javascript:void(0);" class="text-danger" title="Klik Detail" wire:click="showDetailCancelation('.$end->id.')">'.$end->konven_memo_pos->no_dn_cn.'</a>'!!} <span class="badge badge-warning">{{$end->type}}</span></p> 
                                            @if($end->type=='CN') @php($end_cn += $end->nominal) @endif
                                            @if($end->type=='DN') @php($end_dn += $end->nominal) @endif
                                            @endforeach
                                        </td>
                                    </tr> 
                                    <tr>
                                        <th>{{ __('Total After Endorsement')}}</th>
                                        <td>
                                            @php($data->payment_amount = $data->nominal-$end_cn+$end_dn)
                                            {{format_idr($data->nominal-$end_cn+$end_dn)}}
                                        </td>
                                    </tr>
                                    @endif
                                @endif
                                <tr>
                                    <th>{{ __('Payment Amount')}}</th>
                                    <td>
                                        <input type="text" class="form-control format_number col-md-6" {{$is_readonly?'disabled':''}} wire:model="payment_amount" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Outstanding')}}</th>
                                    <td>{{format_idr($outstanding_balance)}}</td>
                                </tr>
                                <tr>
                                    <th>{{__('Payment Date')}}*<small>{{__('Default today')}}</small></th>
                                    <td>
                                        <input type="date" class="form-control col-md-6" {{$is_readonly?'disabled':''}} wire:model="payment_date" />
                                        @error('payment_date')
                                        <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th>Titipan Premi</th>
                                    <td>
                                        @if($titipan_premi)
                                            <p>
                                                No Voucher : <a href="{{route('income.titipan-premi.detail',$titipan_premi->id)}}" target="_blank">{{$titipan_premi->no_voucher}}</a> <br />
                                                {{isset($titipan_premi->from_bank_account->no_rekening) ? $titipan_premi->from_bank_account->no_rekening .'- '.$titipan_premi->from_bank_account->bank.' an '. $titipan_premi->from_bank_account->owner : '-'}} <br />
                                                 <strong>{{format_idr($titipan_premi->nominal)}}</strong>
                                                @if(!$is_readonly)
                                                 <a href="javascript:void(0)" wire:click="clearTitipanPremi" class="text-danger"><i class="fa fa-times"></i></a>
                                                @endif
                                            </p>
                                        @else
                                            @if(!$is_readonly)
                                            <a href="javascript:void(0)" data-target="#modal_add_titipan_premi" data-toggle="modal"><i class="fa fa-plus"></i> Titipan Premi</a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{__('From Bank Account')}}</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <select class="form-control from_bank_account" id="from_bank_account_id" wire:model="from_bank_account_id" {{$is_readonly?'disabled':''}}>
                                                    <option value=""> --- {{__('Select')}} --- </option>
                                                    @foreach (\App\Models\BankAccount::where('is_client',1)->orderBy('owner','ASC')->get() as $bank)
                                                        <option value="{{ $bank->id}}">{{ $bank->owner }} - {{ $bank->no_rekening}} {{ $bank->bank}}</option>
                                                    @endforeach
                                                </select>
                                                @error('from_bank_account_id')
                                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 px-0 pt-2">
                                                @if(!$is_readonly)
                                                <a href="#" data-toggle="modal" data-target="#modal_add_bank"><i class="fa fa-plus"></i> Add Bank</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{__('To Bank Account')}}</th>
                                    <td>
                                        <select class="form-control" wire:model="bank_account_id" {{$is_readonly?'disabled':''}}>
                                            <option value=""> --- {{__('Select')}} --- </option>
                                            @foreach (\App\Models\BankAccount::where('is_client',0)->orderBy('owner','ASC')->get() as $bank)
                                                <option value="{{ $bank->id}}">{{ $bank->owner }} - {{ $bank->no_rekening}} {{ $bank->bank}}</option>
                                            @endforeach
                                        </select>
                                        @error('bank_account_id')
                                        <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{__('Bank Charges')}}</th>
                                    <td><input type="text" {{$is_readonly?'disabled':''}} class="form-control format_number col-md-6" wire:model="bank_charges" /></td>
                                </tr>
                                <tr>
                                    <th>{{__('Description')}}</th>
                                    <td>
                                        <textarea style="height:100px;" {{$is_readonly?'disabled':''}} class="form-control" wire:model="description"></textarea>
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                    </div>
                    <hr />
                    <a href="javascript:void0()" onclick="history.back()"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    @if(!$is_readonly)
                    <button type="submit" class="ml-3 btn btn-primary btn-sm"><i class="fa fa-save"></i> {{ __('Receive') }}</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-5 px-0">
        @if($showDetail=='cancelation')
        <div class="card mt-0">
            <div wire:loading style="position:absolute;right:0;">
                <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                <span class="sr-only">Loading...</span>
            </div>
            <div class="body" style="max-height:700px;overflow-y:scroll">
                <h6 class="text-danger">{{$cancelation->konven_memo_pos->no_dn_cn}}</h6>
                <hr />
                <table class="table pl-0 mb-0 table-striped table-nowrap"> 
                    @foreach(\Illuminate\Support\Facades\Schema::getColumnListing('konven_memo_pos') as $column)
                    @if($column=='id' || $column=='created_at'||$column=='updated_at') @continue @endif
                    <tr>
                        <th style="width:40%;">{{ ucfirst($column) }}</th>
                        <td style="width:60%;">{{$cancelation->konven_memo_pos->$column }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endif
        @if($showDetail=='underwriting')
        <div class="card mt-0">
            <div wire:loading style="position:absolute;right:0;">
                <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                <span class="sr-only">Loading...</span>
            </div>
            <div class="body" style="max-height:700px;overflow-y:scroll">
                <h6 style="color:#007bff">{{$data->reference_no}}</h6>
                <hr />
                @if($data->uw)
                <table class="table pl-0 mb-0 table-striped table-nowrap"> 
                    <tr>
                        <th style="width:40%;">Bulan</th>
                        <td style="width:60%;">{{$data->uw->bulan }}</td>
                    </tr>
                    <tr>
                        <th>User Memo</th>
                        <td>{{$data->uw->user_memo }}</td>
                    </tr>
                    <tr>
                        <th>User Akseptasi</th>
                        <td>{{$data->uw->user_akseptasi }}</td>
                    </tr>
                    <tr>
                        <th>Transaksi ID</th>
                        <td>{{$data->uw->transaksi_id }}</td>
                    </tr>
                    <tr>
                        <th>Berkas Akseptasi</th>
                        <td>{{$data->uw->berkas_akseptasi }}</td>
                    </tr>
                    <tr>
                        <th>Tgl Pengajuan Email</th>
                        <td>{{$data->uw->tanggal_pengajuan_email }}</td>
                    </tr>
                    <tr>
                        <th>Tgl Produksi</th>
                        <td>{{$data->uw->tanggal_produksi}}</td>
                    </tr>
                    <tr>
                        <th>No Reg</th>
                        <td>{{$data->uw->no_reg}}</td>
                    </tr>
                    <tr>
                        <th>No Polis</th>
                        <td>{{$data->uw->no_polis}}</td>
                    </tr>
                    <tr>
                        <th>Polis Sistem</th>
                        <td>{{$data->uw->no_polis_sistem}}</td>
                    </tr>
                    <tr>
                        <th>Pemegang Polis</th>
                        <td>{{$data->uw->pemegang_polis}}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{$data->uw->alamat}}</td>
                    </tr>
                    <tr>
                        <th>Cabang</th>
                        <td>{{$data->uw->cabang}}</td>
                    </tr>
                    <tr>
                        <th>Produk</th>
                        <td>{{$data->uw->produk}}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Peserta Pending</th>
                        <td>{{$data->uw->jumlah_peserta_pending}}</td>
                    </tr>
                    <tr>
                        <th>UP Peserta Pending</th>
                        <td>{{format_idr($data->uw->up_peserta_pending)}}</td>
                    </tr>
                    <tr>
                        <th>Premi Peserta Pending</th>
                        <td>{{format_idr($data->uw->premi_peserta_pending)}}</td>
                    </tr>
                    <tr>
                        <th>Jml Peserta</th>
                        <td>{{$data->uw->jumlah_peserta}}</td>
                    </tr>
                    <tr>
                        <th>No Peserta</th>
                        <td>{{$data->uw->no_peserta_awal}} sd {{$data->uw->no_peserta_akhir}}</td>
                    </tr>
                    <tr>
                        <th>Periode Awal</th>
                        <td>{{$data->uw->periode_awal}}</td>
                    </tr>
                    <tr>
                        <th>Periode Akhir</th>
                        <td>{{$data->uw->periode_akhir}}</td>
                    </tr>
                    <tr>
                        <th>UP</th>
                        <td>{{format_idr($data->uw->up)}}</td>
                    </tr>
                    <tr>
                        <th>Premi Gross</th>
                        <td>{{format_idr($data->uw->premi_gross)}}</td>
                    </tr>
                    <tr>
                        <th>Extra Premi</th>
                        <td>{{format_idr($data->uw->extra_premi)}}</td>
                    </tr>
                    <tr>
                        <th>Discount</th>
                        <td>{{$data->uw->discount}}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Discount</th>
                        <td>{{format_idr($data->uw->jumlah_discount)}}</td>
                    </tr>
                    <tr>
                        <th>Jumlah CAD Klaim</th>
                        <td>{{$data->uw->jumlah_cad_klaim}}</td>
                    </tr>
                    <tr>
                        <th>Ext Diskon</th>
                        <td>{{$data->uw->ext_diskon}}</td>
                    </tr>
                    <tr>
                        <th>Cad Klaim</th>
                        <td>{{$data->uw->cad_klaim}}</td>
                    </tr>
                    <tr>
                        <th>Handling Fee</th>
                        <td>{{$data->uw->handling_fee}}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Fee</th>
                        <td>{{$data->uw->jumlah_fee}}</td>
                    </tr>
                    <tr>
                        <th>PPH</th>
                        <td>{{$data->uw->pph}}</td>
                    </tr>
                    <tr>
                        <th>Jumlah PPH</th>
                        <td>{{$data->uw->jumlah_pph}}</td>
                    </tr>
                    <tr>
                        <th>PPN</th>
                        <td>{{$data->uw->ppn}}</td>
                    </tr>
                    <tr>
                        <th>Jumlah PPN</th>
                        <td>{{format_idr($data->uw->jumlah_ppn)}}</td>
                    </tr>
                    <tr>
                        <th>Biaya Polis</th>
                        <td>{{format_idr($data->uw->biaya_polis)}}</td>
                    </tr>
                    <tr>
                        <th>Biaya Sertifikat</th>
                        <td>{{$data->uw->biaya_sertifikat}}</td>
                    </tr>
                    <tr>
                        <th>Extsertifikat</th>
                        <td>{{$data->uw->extsertifikat}}</td>
                    </tr>
                    <tr>
                        <th>Premi Netto</th>
                        <td>{{$data->uw->extra_premi}}</td>
                    </tr>
                    <tr>
                        <th>Terbilang</th>
                        <td>{{$data->uw->terbilang}}</td>
                    </tr>
                    <tr>
                        <th>Tgl Update Database</th>
                        <td>{{$data->uw->tgl_update_database}}</td>
                    </tr>
                    <tr>
                        <th>Tgl Update Sistem</th>
                        <td>{{$data->uw->tgl_update_sistem}}</td>
                    </tr>
                    <tr>
                        <th>No Berkas Sistem</th>
                        <td>{{$data->uw->no_berkas_sistem}}</td>
                    </tr>
                    <tr>
                        <th>Tgl Posting Sistem</th>
                        <td>{{$data->uw->tgl_posting_sistem}}</td>
                    </tr>
                    <tr>
                        <th>Ket Posting</th>
                        <td>{{$data->uw->ket_posting}}</td>
                    </tr>
                    <tr>
                        <th>Tgl Invoice</th>
                        <td>{{$data->uw->tgl_invoice}}</td>
                    </tr>
                    <tr>
                        <th>No Kwitansi / Debit Note</th>
                        <td>{{$data->uw->no_kwitansi_debit_note}}</td>
                    </tr>
                    <tr>
                        <th>Total Gross Kwitansi</th>
                        <td>{{format_idr($data->uw->total_gross_kwitansi)}}</td>
                    </tr>
                    <tr>
                        <th>Grace Periode Terbilang</th>
                        <td>{{$data->uw->grace_periode_terbilang}}</td>
                    </tr>
                    <tr>
                        <th>Grace Periode</th>
                        <td>{{$data->uw->grace_periode}}</td>
                    </tr>
                    <tr>
                        <th>Tgl Jatuh Tempo</th>
                        <td>{{$data->uw->tgl_jatuh_tempo}}</td>
                    </tr>
                    <tr>
                        <th>Extend Tgl Jatuh Tempo</th>
                        <td>{{$data->uw->extend_tgl_jatuh_tempo}}</td>
                    </tr>
                    <tr>
                        <th>Tgl Lunas</th>
                        <td>{{$data->uw->tgl_lunas}}</td>
                    </tr>
                    <tr>
                        <th>Ket Lampiran</th>
                        <td>{{$data->uw->ket_lampiran}}</td>
                    </tr>
                    <tr>
                        <th>Line Bussines</th>
                        <td>{{$data->uw->line_bussines}}</td>
                    </tr>
                </table>
                @endif
            </div>
        </div>
        @endif
    </div>
    <div wire:ignore.self class="modal fade" id="modal_add_bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <livewire:income-premium-receivable.add-bank />
        </div>
    </div>
</div>
@push('after-scripts')
<script src="{{ asset('assets/js/jquery.priceformat.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}"/>
<script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
<style>
    .select2-container .select2-selection--single {height:36px;padding-left:10px;}
    .select2-container .select2-selection--single .select2-selection__rendered{padding-top:3px;}
    .select2-container--default .select2-selection--single .select2-selection__arrow{top:4px;right:10px;}
    .select2-container {width: 100% !important;}
</style>
<script>
Livewire.on('set-titipan-premi',(id)=>{
    $("#modal_add_titipan_premi").modal("hide");
});
document.addEventListener("livewire:load", () => {
    init_form();
});
$(document).ready(function() {
    setTimeout(function(){
        init_form()
    })
});
var select__2;
function init_form(){
    $('.format_number').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: '.',
        centsLimit: 0
    });
    select__2 = $('.from_bank_account').select2();
    $('.from_bank_account').on('change', function (e) {
        let elementName = $(this).attr('id');
        var data = $(this).select2("val");
        @this.set(elementName, data);
    });
    var selected__ = $('.from_bank_account').find(':selected').val();
    if(selected__ !="") select__2.val(selected__);
}
Livewire.on('init-form',()=>{
    init_form();
});
Livewire.on('emit-add-bank',id=>{
    $("#modal_add_bank").modal('hide');
    select__2.val(id);
})
</script>
@endpush
<div wire:ignore.self class="modal fade" id="modal_add_titipan_premi" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="min-width:90%; role="document">
        <livewire:income-premium-receivable.add-titipan-premi />
    </div>
</div>