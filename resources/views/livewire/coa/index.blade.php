@section('title', 'COA (Chart Of Account)')
@section('parentPageTitle', 'Home')

<div class="clearfix row">
    <div class="col-lg-9">
        <div class="card">
            <div class="header row">
                <div class="col-md-1">
                    <a href="{{route('coa.insert')}}" class="btn btn-primary"><i class="fa fa-plus"></i> COA</a>
                </div>
            </div>
            <div class="pt-0 body">
                <div class="table-responsive">
                    <table class="table table-striped m-b-0 c_list">
                        @foreach(\App\Models\CoaGroup::orderBy('name')->get() as $group)
                            <tr>
                                <th><a href="{{route('coa-group.edit',['id'=>$group->id])}}">{{$group->name}}</a></th>
                                <th>{{$group->code}}</th>
                                <th></th>
                                <th class="text-right">Opening Balance</th>
                            </tr>
                            @foreach(\App\Models\Coa::where('coa_group_id',$group->id)->get() as $k => $coa)
                            <tr>
                                <td><a href="{{route('coa.edit',['id'=>$coa->id])}}">{{$coa->name}}</a></td>
                                <td>{{$coa->code}}</td>
                                <td>{{$coa->code_voucher}}</td>
                                <td class="text-right">
                                    {{format_idr($coa->opening_balance)}}
                                </td>
                            </tr>
                            @endforeach
                            <tr><td colspan="6">&nbsp;</td></tr>
                        @endforeach
                    </table>
                </div>
                <br />
            </div>
        </div>
    </div>
</div>