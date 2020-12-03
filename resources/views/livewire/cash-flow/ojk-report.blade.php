<div>
    <div class="px-0 pt-0 header row">
        <div class="col-md-2">
            <select class="form-control" wire:model="year">
                <option value=""> -- Year -- </option>
                @foreach(\App\Models\Journal::select( DB::raw( 'YEAR(date_journal) AS year' ))->groupBy('year')->get() as $i)
                <option>{{$i->year}}</option>
                @endforeach
            </select>
        </div>
        <div class="px-0 col-md-4">
            <a href="javascript:void(0)" class="btn btn-info" wire:click="downloadExcel"><i class="fa fa-download"></i> Download Excel</a>
        </div>
    </div>
    <div class="px-0 table-responsive">
        <table class="table table-striped m-b-0 c_list table-bordered">
            <tr>
                <td></td>
                @foreach(month() as $m)
                    <th>{{$m}}</th>
                @endforeach
            </tr>
            <tr>
                <th>SALDO AWAL KAS DAN BANK</th>
                @foreach(month() as $m)
                    <th></th>
                @endforeach
            </tr>
            <tr>
                <th>ARUS KAS DARI AKTIVITAS OPERASI</th>
                @foreach(month() as $m)
                    <th></th>
                @endforeach
            </tr>
            <tr>
                <th>Arus Kas Masuk</th>
                @foreach(month() as $m)
                    <th></th>
                @endforeach
            </tr>
            <tr>
                <td>a. Premi</td>
                @foreach(month() as $m)
                    <th></th>
                @endforeach
            </tr>
            <tr>
                <td>b. Klaim Koasuransi</td>
                @foreach(month() as $m)
                    <th></th>
                @endforeach
            </tr>
        </table>
    </div>
</div>