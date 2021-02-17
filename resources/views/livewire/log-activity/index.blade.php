@section('title', 'All Activity')
@section('parentPageTitle', 'Log Activity')
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header row">
                <div class="col-md-3">
                    <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                </div>
                <div class="col-md-2">
                    <select class="form-control" wire:model="user_id">
                        <option value=""> --- User --- </option>
                        @foreach(\App\Models\User::orderBy('name','ASC')->get() as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover m-b-0 c_list">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Subject</th>
                                <th>URL</th>
                                <th>Method</th>
                                <th>IP</th>
                                <th>Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$k+1}}</td>
                                <td>{{isset($item->user->name) ? $item->user->name : ''}}</td> 
                                <td>{{$item->subject}}</td> 
                                <td>{{$item->url}}</td> 
                                <td>{{$item->method}}</td> 
                                <td>{{$item->ip}}</td> 
                                <td>{{$item->agent}}</td> 
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