@section('title', __('Index'))
@section('parentPageTitle', __('Bank Book'))
<div class="clearfix row">
    @push('after-scripts')
        <script type="text/javascript" src="{{ asset('assets/vendor/daterange/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/vendor/daterange/daterangepicker.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/daterange/daterangepicker.css') }}" />
    @endpush
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="tabbable">
                    <ul class="nav nav-tabs-new2">
                        @foreach(\App\Models\BankAccount::where('is_client',0)->where('status',1)->get() as $k=>$item)
                            <li class="nav-item">
                                <a class="nav-link {{$set_active==$item->id?'active':''}}" wire:loading.remove wire:target="set_active_({{$item->id}})" wire:click="set_active_({{$item->id}})" data-toggle="tab" href="#bank-{{$item->id}}">{{ $item->bank }}</a>
                                <a class="nav-link" wire:loading wire:target="set_active_({{$item->id}})">
                                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                    <span class="sr-only">{{ __('Loading...') }}</span> Please wait...
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="px-0 tab-content">
                    @foreach(\App\Models\BankAccount::where('is_client',0)->where('status',1)->get() as $k=> $item)
                        <div class="tab-pane {{$set_active==$item->id?'show active':''}}" id="bank-{{$item->id}}" x-data="{ insert:false }">
                            @livewire('bank-book.detail',['data'=>$item,'active'=>$set_active,'is_first'=>$k],key($item->id))
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@push('after-scripts')
    <script>
        Livewire.on('update-url',(url)=>{
            setTimeout(function(){
                window.history.pushState('', '', url);
            });
        })
    </script>
    <style>
        .tabbable .nav-tabs-new2 {
            overflow-x: auto;
            overflow-y:hidden;
            flex-wrap: nowrap;
        }
        .tabbable .nav-tabs-new2 .nav-link {
            white-space: nowrap;
        }
    </style>
@endpush