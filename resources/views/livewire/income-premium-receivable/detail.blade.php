@section('title', 'Premium Receivable '.$data->no_voucher)
@section('parentPageTitle', 'Home')
<div class="clearfix row">
    <div class="col-md-7">
        <div class="card">
            <div class="body">
                <form id="basic-form" method="post" wire:submit.prevent="save">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table pl-0 mb-0 table-striped">
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
                                            <span class="badge badge-danger" title="Premi Cancel">Cancel</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Reference Date')}}</th>
                                    <td>{{$data->reference_date}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Premium Receivable')}}</th>
                                    <td>{{format_idr($data->nominal)}}</td>
                                </tr>
                                @if($data->cancelation->count())
                                <tr>
                                    <th>{{ __('Cancelation')}}</th>
                                    <td>
                                        @foreach($data->cancelation as $cancel)
                                        {!!format_idr($cancel->nominal).' - <a href="#" class="text-danger" title="Klik Detail" wire:click="showDetailCancelation('.$cancel->id.')">'.$cancel->konven_memo_pos->no_dn_cn.'</a>'!!} 
                                        @endforeach
                                    </td>
                                </tr> 
                                <tr>
                                    <th>{{ __('Total After Cancelation')}}</th>
                                    <td>{{format_idr($data->nominal-$data->cancelation->sum('nominal'))}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>{{ __('Payment Amount')}}</th>
                                    <td>
                                        <input type="text" class="form-control col-md-6" {{$is_readonly?'disabled':''}} wire:model="payment_amount" />
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <th>{{ __('Outstanding Balance')}}</th>
                                    <td>{{$outstanding_balance}}</td>
                                </tr> --}}
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
                                    <th>{{__('From Bank Account')}}</th>
                                    <td>
                                        <select class="form-control" wire:model="from_bank_account_id" {{$is_readonly?'disabled':''}}>
                                            <option value=""> --- {{__('Select')}} --- </option>
                                            @foreach (\App\Models\BankAccount::where('is_client',1)->orderBy('owner','ASC')->get() as $bank)
                                                <option value="{{ $bank->id}}">{{ $bank->owner }} - {{ $bank->no_rekening}} {{ $bank->bank}}</option>
                                            @endforeach
                                        </select>
                                        @error('from_bank_account_id')
                                        <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
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
                    <button type="button" class="ml-3 btn btn-danger btn-sm float-right" data-target="#modal_confirm" data-toggle="modal" wire:click="cancel"><i class="fa fa-times"></i> {{ __('Cancel Premi') }}</button>
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
    
</div>
@push('after-scripts')
<script src="{{ asset('assets/js/jquery.priceformat.min.js') }}"></script>
@endpush
@section('page-script')
Livewire.on('changeForm', () =>{
    setTimeout(function(){
        init_form();
    },500);
});
function init_form(){
    $('.format_number').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: '.',
        centsLimit: 0
    });
}
setTimeout(function(){
    init_form()
})
@endsection