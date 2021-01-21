@section('title', 'Endorsement')
@section('parentPageTitle', 'Dashboard')
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#db">Debit Note</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cn">Credit Note</a></li>
                </ul>
                <div class="px-0 tab-content">
                    <div class="tab-pane show active" id="db">
                        <livewire:endorsement.dn />
                    </div>
                    <div class="tab-pane" id="cn">
                        <livewire:endorsement.cn />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>