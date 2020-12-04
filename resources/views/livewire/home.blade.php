@section('title', 'Report')
@section('parentPageTitle', 'Dashboard')

<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#payable">Journal</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#receivable">Cash Flow</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="payable">
                        <livewire:journal.index />
                    </div>
                    <div class="tab-pane" id="receivable">
                        <livewire:cash-flow.index />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>