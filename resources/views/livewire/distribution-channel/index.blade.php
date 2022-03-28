@section('title', 'Distribution Channel')
@section('parentPageTitle', 'Home')

<div class="clearfix row">
    <div class="col-lg-9">
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
                    <a href="javascript:void()" wire:click="$set('is_insert',true)" class="btn btn-primary"><i class="fa fa-plus"></i> Distribution Channel</a>
                </div>
            </div>
            <div class="pt-0 body">
                <div class="table-responsive">
                    <table class="table table-striped m-b-0 c_list">
                        <tr>
                            <th>Type</th>
                            <th>Channel</th>
                        </tr>
                        @if($is_insert)
                            <tr>
                                <td>
                                    <input type="text" class="form-control" wire:model="name" placeholder="Name" />
                                </td>
                                <td>
                                    <input type="text" class="form-control" wire:model="description" placeholder="Description" />
                                </td>
                                <td>
                                    <a href="javascript:void()" wire:click="save" class="badge badge-info badge-active"><i class="fa fa-save"></i> Save</a>
                                </td>
                            </tr>
                        @endif
                        @foreach($data as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{$item->description}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <br />
            </div>
        </div>
    </div>
</div>