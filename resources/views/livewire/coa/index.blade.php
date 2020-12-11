@section('title', 'COA')
@section('parentPageTitle', 'Home')

<div class="clearfix row">
    <div class="col-lg-5">
        <div class="card">
            <div class="header row">
                {{-- <div class="col-md-2">
                    <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                </div>
                <div class="px-0 col-md-2">
                    <select class="form-control" wire:model="coa_group_id">
                        <option value=""> --- COA Group --- </option>
                        @foreach(\App\Models\CoaGroup::orderBy('name','ASC')->get() as $i)
                        <option value="{{$i->id}}">{{$i->name}}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="col-md-1">
                    <a href="{{route('coa.insert')}}" class="btn btn-primary"><i class="fa fa-plus"></i> COA</a>
                </div>
            </div>
            <div class="pt-0 body">
                <div class="table-responsive">
                    <table class="table table-striped m-b-0 c_list">
                        @foreach(\App\Models\CoaGroup::orderBy('name')->get() as $group)
                            <tr>
                                <th>{{$group->name}}</th>
                                <th>{{$group->code}}</th>
                                <th></th>
                            </tr>
                            @foreach(\App\Models\Coa::where('coa_group_id',$group->id)->get() as $coa)
                            <tr>
                                <td><a href="{{route('coa.edit',['id'=>$coa->id])}}">{{$coa->name}}</a></td>
                                <td>{{$coa->code}}</td>
                                <td>{{$coa->code_voucher}}</td>
                            </tr>
                            @endforeach
                            <tr><td colspan="3">&nbsp;</td></tr>
                        @endforeach
                    </table>
                </div>
                <br />
            </div>
        </div>
    </div>
</div>