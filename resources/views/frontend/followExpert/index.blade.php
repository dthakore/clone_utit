@extends('layouts.frontend-new', [
    "title" => "Follow Expert",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "/"
        ],
        [
            "title" => "Follow Expert"
        ]
    ]
])
<style>
    #chart {
        max-width: 650px;
        margin: 35px auto;
    }

</style>
@section('content')

    <div class="row">
        @if(count($experts)>0)
            @foreach($experts as $expert)
                <?php //dd($expert); ?>
                <div class="col-sm-6 col-xs-6 col-xl-4 col-lg-4 utit_experts">
                    <div class="card user-wideget user-wideget-widget widget-user">
                        <div class="widget-user-header br-te-5  br-ts-5  bg-primary">
                            <h3 class="widget-user-username">
                                {{$expert->name}}
                                @if($expert->is_verified == 1)
                                    <i class="fa fa-check-circle text-white"></i>
                                @endif
                            </h3>
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="widget-user-desc">MAM ID : {{$expert->account}}</h6>
                                    <h6 class="widget-user-desc">Asset Manager : @if(isset($expert->asset_manager)){{$expert->asset_manager}}@else -@endif</h6>
                                </div>
                                <div class="col-6">
                                    <h6 class="widget-user-desc">MAM Settings : @if(isset($expert->setting)) {{$expert->setting}}@else -@endif</h6>
                                </div>
                            </div>
                        </div>
                        <div class="widget-user-image text-center">
                            <span class="fas plan-icon text-blue">{{$expert->initals}}</span>
                            <!-- <i class="fas si si-user-following text-blue plan-icon"></i> -->
                        </div>
                        <div class="user-wideget-footer expert_icons">
                            <div class="row">
                                <div class="col-sm-4 border-end pe-0">
                                    <div class="description-block">
                                        @if(isset($expert->asset_type))
                                            <h5 class="description-header">{{$expert->asset_type}}</h5>
                                        @else
                                            <h5 class="description-header">-</h5>
                                        @endif
                                        <span class="description-text">Asset Type</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-end pe-1 ps-2">
                                    <div class="description-block">
                                        <h5 class="description-header">€ {{isset($expert->minimum_deposit) ? $expert->minimum_deposit : 0}}</h5>
                                        <span class="description-text">Minimunm Invest</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            <span class="badge badge-success">{{ !empty((float)$expert->abs_gain) ? round((float)$expert->abs_gain,2) : 0 }} % </span></h5>
                                        <span class="description-text">Abs.Gain</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="user-wideget-footer expert_icons pt-2">
                            <div class="row">
                                <div class="col-sm-4 border-end">
                                    <div class="description-block">
                                        <h5 class="description-header">{{isset($expert->total_investors) ? $expert->total_investors : 0}}</h5>
                                        <span class="description-text">INVESTORES</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-end">
                                    <div class="description-block">
                                        <h5 class="description-header">€{{isset($expert->aum) ? $expert->aum : 0}}</h5>
                                        <span class="description-text">AUM</span>
                                    </div>
                                </div>

                                <div class="col-sm-4 ps-0">
                                    <div class="description-block">
                                        <h5 class="description-header"><span class="badge badge-purple">{{ !empty($expert->max_dd) ? round((float)$expert->max_dd,2) : 0 }} %  </span></h5>
                                        <span class="description-text">Max DD</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="user-wideget-footer pt-3">
                            <div class="row">
                                <div class="col-lg-10 offset-1">
                                    <div class="d-sm-flex">
                                        <div>
                                            <input type="hidden" id="balance_"{{(count($expert->balance)>0)?$expert->balance:""}}>
                                            <input type="hidden" id="dates_"{{(count($expert->dates)>0)?$expert->dates:""}}>
                                            <div id="chart_"{{$expert->id}}>
                                            </div>
                                            {{--<img alt="Chart" src="{{asset('assets/img/chart.png')}}" class="img-responsive" />--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="user-wideget-footer expert_icons pt-0">
                            <div class="row">
                                @if(count($expert->icons) > 0)
                                    @foreach($expert->icons as $ei)
                                        <div class="col-sm-2 border-end border-bottom">
                                            <div class="description-block">
                                                <img data-bs-placement="top" data-bs-toggle="tooltip" title="{{$ei['tooltip']}}"  src="{{$ei['url']}}" class="product_image pic-1" alt="Image" />
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="pt-0 buttons">
                            <div class="row">
                                <div class="col-sm-6 pe-0 ps-4 pe-1">
                                    <button type="button" class="btn btn-block btn-warning button-icon">View Profile</button>
                                </div>
                                <div class="col-sm-6 ps-1 pe-4">
                                    <button type="button" class="btn btn-block btn-primary button-icon">View Details</button>
                                </div>
                                <div class="col-sm-12 ps-4 pe-4 pt-2 pb-2">
                                    {{-- <form method="POST" action="{{ route('frontend.user-request.post')}}" enctype="multipart/form-data"> --}}
                                    <form class="formSubmit" id="formSubmit{{$expert->id}}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{auth()->user()->id}}" />
                                        <input type="hidden" name="user_name" value="{{auth()->user()->name}}" />
                                        <input type="hidden" class="expert_id" name="expert_id" value="{{$expert->id}}" />
                                        <input type="hidden" class="expert_name" name="expert_name" value="{{$expert->name}}" />
                                        @if($expert->disabled === true)
                                            <button type="button" class="btn btn-outline-success btn-block button-icon"  id="">Following</button>
                                        @else
                                            <button type="button" class="btn btn-block  btn-success button-icon submit_data"  id="">Follow Experts</button>
                                    @endif
                                    <!-- <button type="button" class="btn btn-block  btn-success button-icon submit_data"  id="">Follow Experts</button> -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        @endif
    </div>

@endsection

@section('scripts')

    <!-- Internal Jquery-sparkline js -->
    <script src="{{asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('assets/js/chart.sparkline.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @parent
    <script>
        var experts = '{{$expert}}';
        console.log(experts);
        var options = {
            series: [{
                name: "Desktops",
                data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            // title: {
            //     text: 'Product Trends by Month',
            //     align: 'left'
            // },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            },
            yaxis: {
                show: true,
                showAlways: true,
                showForNullSeries: true,
                seriesName: undefined,
                opposite: false,
                reversed: false,
                logarithmic: false,
                logBase: 10,
                tickAmount: 6,
                min: 6,
                max: 6,
                forceNiceScale: false,
                floating: false,
                decimalsInFloat: undefined,
                labels: {
                    show: true,
                    align: 'right',
                    minWidth: 0,
                    maxWidth: 160,
                    style: {
                        colors: [],
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 400,
                        cssClass: 'apexcharts-yaxis-label',
                    },
                    offsetX: 0,
                    offsetY: 0,
                    rotate: 0,
                    formatter: (value) => { return val },
                },
                axisBorder: {
                    show: true,
                    color: '#78909C',
                    offsetX: 0,
                    offsetY: 0
                },
                axisTicks: {
                    show: true,
                    borderType: 'solid',
                    color: '#78909C',
                    width: 6,
                    offsetX: 0,
                    offsetY: 0
                },
                title: {
                    text: undefined,
                    rotate: -90,
                    offsetX: 0,
                    offsetY: 0,
                    style: {
                        color: undefined,
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 600,
                        cssClass: 'apexcharts-yaxis-title',
                    },
                },
                crosshairs: {
                    show: true,
                    position: 'back',
                    stroke: {
                        color: '#b6b6b6',
                        width: 1,
                        dashArray: 0,
                    },
                },
                tooltip: {
                    enabled: true,
                    offsetX: 0,
                },

            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();


        $(document).on('click', '.submit_data', function(e) {
            e.preventDefault();
            if(!$(this).disable){
                // toastr.options = {
                // "positionClass": "toast-top-full-width"
                // };
                var expert_id = $(this).parent(".formSubmit").find('.expert_id').val();
                console.log(expert_id)
                var form_data = new FormData(document.getElementById("formSubmit"+expert_id));
                $(this).attr('disabled',true)
                $(this).text('Following')
                $(this).removeClass('btn-success')
                $(this).addClass('btn-outline-success')
                $.ajax({
                    url: "{{ url('user-request')}}",
                    type: 'POST',
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        if(res.status == 1){
                            toastr.success(res.success);

                        }else{
                            toastr.warning('Data not insert');
                        }

                    }
                });
            }



        });
    </script>
@endsection