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
                                    <td><a href="#" wire:click="detailDN" title="Detail Debit Note / Kwitansi Number">{{$data->reference_no}}</a></td>
                                </tr>
                                <tr>
                                    <th>{{ __('Reference Date')}}</th>
                                    <td>{{$data->reference_date}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Cancelation')}}</th>
                                    <td>{!!isset($data->cancelation)?'<span class="text-danger">'.format_idr($data->cancelation->sum('nominal')).'</span>':0!!}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Total')}}</th>
                                    <td>{{format_idr($data->nominal)}}</td>
                                </tr>
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
                                    <th>{{__('Bank Account')}}</th>
                                    <td>
                                        <select class="form-control" wire:model="bank_account_id" {{$is_readonly?'disabled':''}}>
                                            <option value=""> --- {{__('Select')}} --- </option>
                                            @foreach (\App\Models\BankAccount::orderBy('owner','ASC')->get() as $bank)
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
                                        <textarea style="height:100px;" class="form-control" wire:model="description"></textarea>
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                    </div>
                    <hr />
                    <a href="javascript:void0()" onclick="history.back()"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    <button type="submit" class="ml-3 btn btn-primary"><i class="fa fa-save"></i> {{ __('Submit') }}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-5 px-0">
        <div class="card mb-2">
            <div class="body">
                <h6 class="text-danger">Cancelation</h6>
                <hr />
                @if($data->cancelation)
                    <table class="table pl-0 mb-0 table-striped"> 
                        <tr>
                            <th>No Credit Note</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                        </tr>
                        @foreach($data->cancelation as $cancel)
                        <tr>
                            <td>{{$cancel->konven_memo_pos->no_dn_cn}}</td>
                            <td>{{$cancel->konven_memo_pos->tgl_produksi}}</td>
                            <td>{{$cancel->konven_memo_pos->ket_perubahan1}}</td>
                            <td>{{format_idr($cancel->nominal)}}</td>
                        </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
        <div class="card mt-0">
            <div class="body" style="max-height:500px;overflow-y:scroll">
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
                        <td>{{$data->uw->tanggal_produksi}}</td>
                    </tr>
                    <tr>
                        <th>Premi Peserta Pending</th>
                        <td>{{$data->uw->premi_peserta_pending}}</td>
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
                        <td>{{$data->uw->jumlah_discount}}</td>
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
                        <td>{{$data->uw->jumlah_ppn}}</td>
                    </tr>
                    <tr>
                        <th>Biaya Polis</th>
                        <td>{{$data->uw->biaya_polis}}</td>
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
                        <td>{{$data->uw->total_gross_kwitansi}}</td>
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