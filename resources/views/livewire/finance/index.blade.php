@section('title', 'Report')
@section('parentPageTitle', 'Home')

<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#income">Income</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#expense">Expense</a></li>
                </ul>
                <div class="px-0 tab-content">
                    <div class="tab-pane show active" id="income">
                        <livewire:finance.income />
                    </div>
                    <div class="tab-pane" id="expense">
                        <livewire:finance.expense />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>