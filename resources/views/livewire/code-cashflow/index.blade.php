@section('title', 'COA Group')
@section('parentPageTitle', 'Home')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header row">
                <div class="col-md-2">
                    <select class="form-control" wire:model="group">
                        <option value=""> --- Group --- </option>
                        @foreach(get_group_cashflow() as $k=>$i)
                        <option value="{{$k}}">{{$i}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                </div>
                <div class="col-md-1">
                    <a href="{{route('code-cashflow.insert')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Code Cashflow</a>
                </div>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-striped m-b-0 c_list">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Group</th>                                    
                                <th>Code</th>                                    
                                <th>Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$k+1}}</td>
                                <td>{{get_group_cashflow($item->group)}}</td>
                                <td><a href="{{route('code-cashflow.edit',['id'=>$item->id])}}">{{$item->code}}</a></td>
                                <td><a href="{{route('code-cashflow.edit',['id'=>$item->id])}}">{{$item->name}}</a></td>
                                <td><a href="javascript:void(0)" wire:click="delete({{$item->id}})" class="text-danger"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br />
            </div>
        </div>
    </div>
</div>