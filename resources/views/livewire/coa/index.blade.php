@section('title', 'COA')
@section('parentPageTitle', 'Home')

<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header row">
                <div class="col-md-2">
                    <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                </div>
                <div class="px-0 col-md-2">
                    <select class="form-control" wire:model="coa_group_id">
                        <option value=""> --- COA Group --- </option>
                        @foreach(\App\Models\CoaGroup::orderBy('name','ASC')->get() as $i)
                        <option value="{{$i->id}}">{{$i->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="{{route('coa.insert')}}" class="btn btn-primary"><i class="fa fa-plus"></i> COA</a>
                </div>
            </div>
            <div class="pt-0 body">
                <div class="table-responsive">
                    <table class="table table-striped m-b-0 c_list">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>COA Group</th>                                    
                                <th>Code</th>                                    
                                <th>Account Name</th>                                    
                                <th>Account Type</th>
                                <th>Code Voucher</th>
                                <th>Description</th>
                                {{-- <th></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$k+1}}</td>
                                <td>{{isset($item->group->name) ? $item->group->name : ''}}</td>
                                <td><a href="{{route('coa.edit',['id'=>$item->id])}}">{{$item->code}}</a></td>
                                <td><a href="{{route('coa.edit',['id'=>$item->id])}}">{{$item->name}}</a></td>
                                <td>{{isset($item->type->name) ? $item->type->name : ''}}</td>
                                <td>{{$item->code_voucher}}</td>
                                <td>{{$item->description}}</td>
                                {{-- <td><a href="javascript:void(0)" wire:click="delete({{$item->id}})" class="text-danger"><i class="fa fa-trash"></i></a></td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br />
                {{$data->links()}}
            </div>
        </div>
    </div>
</div>