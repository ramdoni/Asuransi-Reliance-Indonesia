@section('title', 'Report')
@section('parentPageTitle', 'Home')
<div class="row clearfix">
    <div class="col-lg-3 col-md-6">
        <div class="card overflowhidden">
            <div class="body">
                <h3>{{format_idr(\App\Models\Policy::count())}} <i class="icon-user-follow float-right"></i></h3>
                <span>Member</span>                            
            </div>
            <div class="progress progress-xs progress-transparent custom-color-blue m-b-0">
                <div class="progress-bar" data-transitiongoal="64"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card overflowhidden">
            <div class="body">
                <h3>{{format_idr(\App\Models\Income::where('reference_type','Premium Receivable')->sum('payment_amount'))}} <i class="icon-basket-loaded float-right"></i></h3>
                <span>Premium Received</span>                    
            </div>
            <div class="progress progress-xs progress-transparent custom-color-purple m-b-0">
                <div class="progress-bar" data-transitiongoal="67"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card overflowhidden">
            <div class="body">
                <h3>{{format_idr(\App\Models\Income::where('reference_type','Premium Receivable')->sum('outstanding_balance'))}} <i class="fa fa-dollar float-right"></i></h3>
                <span>Outstanding</span>       
            </div>
            <div class="progress progress-xs progress-transparent custom-color-yellow m-b-0">
                <div class="progress-bar" data-transitiongoal="89"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card overflowhidden">
            <div class="body">
                <h3>{{format_idr(\App\Models\Expenses::where('reference_type','Claim')->sum('payment_amount'))}} <i class=" icon-heart float-right"></i></h3>
                <span>Claim</span>        
            </div>
            <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                <div class="progress-bar" data-transitiongoal="68"></div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="header">
                <h2>Annual Report <small>Description text here...</small></h2>
                <ul class="header-dropdown">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another Action</a></li>
                            <li><a href="javascript:void(0);">Something else</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <span class="text-muted">Premium Receivable</span>
                        <h3 class="text-warning">0</h3>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <span class="text-muted">Outstanding Balance </span>
                        <h3 class="text-info">0</h3>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <span class="text-muted">Claim</span>
                        <h3 class="text-success">0</h3>
                    </div>
                </div>
                <div id="area_chart" class="graph"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="header">
                <h2>Income Analysis<small>8% High then last month</small></h2>
            </div>
            <div class="body">                            
                <div class="sparkline-pie text-center">6,4,8</div>
            </div>
        </div>
        <div class="card">
            <div class="header">
                <h2>Sales Income</h2>
            </div>
            <div class="body">
                <h6>Overall <b class="text-success">7,000</b></h6>
                <div class="sparkline" data-type="line" data-spot-Radius="2" data-highlight-Spot-Color="#445771" data-highlight-Line-Color="#222"
                    data-min-Spot-Color="#445771" data-max-Spot-Color="#445771" data-spot-Color="#445771"
                    data-offset="90" data-width="100%" data-height="95px" data-line-Width="1" data-line-Color="#ffcd55"
                    data-fill-Color="#ffcd55">2,4,3,1,5,7,3,2</div>
            </div>
        </div>
    </div>
</div>
@section('page-script')
$(function() {
    "use strict";
    MorrisArea();
});
// progress bars
$('.progress .progress-bar').progressbar({
    display_text: 'none'
});

function MorrisArea() {

    Morris.Area({
        element: 'area_chart',
        data: [{
            period: '2011',
            Sales: 5,
            Revenue: 12,
            Profit: 5
        }, {
            period: '2012',
            Sales: 62,
            Revenue: 10,
            Profit: 5
        }, {
            period: '2013',
            Sales: 20,
            Revenue: 84,
            Profit: 36
        }, {
            period: '2014',
            Sales: 108,
            Revenue: 12,
            Profit: 7
        }, {
            period: '2015',
            Sales: 30,
            Revenue: 95,
            Profit: 19
        }, {
            period: '2016',
            Sales: 25,
            Revenue: 25,
            Profit: 67
        }, {
            period: '2017',
            Sales: 135,
            Revenue: 12,
            Profit: 28
        }

    ],
    lineColors: ['#ffc107', '#17a2b8', '#28a745'],
    xkey: 'period',
    ykeys: ['Sales', 'Revenue', 'Profit'],
    labels: ['Sales', 'Revenue', 'Profit'],
    pointSize: 2,
    lineWidth: 1,
    resize: true,
    fillOpacity: 0.5,
    behaveLikeLine: true,
    gridLineColor: '#e0e0e0',
    hideHover: 'auto'
    });

}
$('.sparkline-pie').sparkline('html', {
    type: 'pie',
    offset: 90,
    width: '155px',
    height: '155px',
    sliceColors: ['#02b5b2', '#445771', '#ffcd55']
})
@endsection