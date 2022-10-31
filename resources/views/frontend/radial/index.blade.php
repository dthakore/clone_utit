@extends('layouts.frontend-new', [
    "title" => "Radial View",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "/"
        ],
        [
            "title" => "Radial"
        ]
    ]
])
@section('styles')
<link href="{{ asset('css/radial/style.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/radial/custom.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/radial/switchery.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/radial/spinners.css') }}" rel="stylesheet"/>
{{--<link href="{{ asset('css/radial/footable.core.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/radial/new-style.css') }}" rel="stylesheet"/>--}}
<style>
    /* basic positioning */
    .legend { list-style: none; }
    .legend li { float: left; margin-right: 10px; }
    .legend span { border: 1px solid #ccc; float: left; width: 12px; height: 12px; margin: 2px; border-radius: 10px}
    /* your colors */
    .legend .self_nodes { background-color: #4BBFF8; }
    .legend .else_nodes { background-color: #F4A540; }
    .table td, .table th{
        padding: 6px 5px;
    }
    .alert {
        padding: 3px 8px!important;
        margin-bottom: unset!important;
    }
</style>
@endsection
@section('content')
<div class="row row-sm">
    <div class="col-lg-12"><a href="#menu-toggle" id="menu-toggle"><i class="fa fa-bars"></i></a>
        <div id="wrapper" class="toggled">
            <div id="sidebar-wrapper">
                <div class="card custom-card">
                    <div class="card-body">
                        <ul class="nav nav-tabs customtab2" role="tablist">
                            <li class="nav-item"><a class="nav-link link-all" data-toggle="tab" href="#tab-all" role="tab"><span>All 100%</span></a></li>
                            <li class="nav-item"><a class="nav-link active link-cb" data-toggle="tab" href="#tab-cb" role="tab"><span data-toggle="tooltip" data-placement="top" title="Cashback Matrix (85.72%)">CB</span></a></li>
                            <li class="nav-item"><a class="nav-link link-ca" data-toggle="tab" href="#tab-ca" role="tab"><span data-toggle="tooltip" data-placement="top" title="Corporate Account (0.0053%)">CA</span></a></li>
                            <li class="nav-item"><a class="nav-link link-ic" data-toggle="tab" href="#tab-ic" role="tab"><span data-toggle="tooltip" data-placement="top" title="Incubator Chain (0.0021%)">IC</span></a></li>
                            <li class="nav-item"><a class="nav-link link-bc" data-toggle="tab" href="#tab-bc" role="tab"><span data-toggle="tooltip" data-placement="top" title="Backup Cycle (0.0053%)">BC</span></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="tab-all" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-striped color-bordered-table primary-bordered-table table-all">
                                        <thead>
                                            <tr>
                                                <th class="col-dark">Comms<br>Volume</th>
                                                <th class="col-dark">CB%</th>
                                                <th class="col-dark" colspan="2">Cashback<div class="text-xs">(if volume are met)</div></th>
                                            </tr>
                                            <tr class="subheading">
                                                <th class="col-dark"></th>
                                                <th class="col-dark"></th>
                                                <th class="col-dark">Potential</th>
                                                <th class="col-dark">Filled</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $total_projected_value = 0;
                                            $total_actual_value = 0;
                                        @endphp
                                        @foreach($matrixPercentageArray as $key => $value)
                                            @php
                                                $comm_value =  0.25 * $matrixSchemeArray[$key];
                                                $projected_value = $comm_value * $value/100;
                                                $actual_value = 0.25 * $nodeLevelCounter[$key] * $value / 100;
                                                $total_projected_value += $projected_value;
                                                $total_actual_value += $actual_value;
                                            @endphp
                                            <tr>
                                                <td class="col-dark" id="all_col1_{{ $key; }}">{{ round($comm_value, 5); }} ‎&euro;</td>
                                                <td class="col-dark" id="all_col2_{{ $key; }}">{{ round($value, 5); }}%</td>
                                                <td class="col-light" id="all_col3_{{ $key; }}">{{ round($projected_value, 5); }} ‎&euro;</td>
                                                <td id="all_col4_{{ $key; }}">{{ round($actual_value, 5); }} ‎&euro;</td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td class="col-dark"></td>
                                                <td class="col-dark">100%</td>
                                                <td class="col-light" id="all_tpv">{{ round($total_projected_value, 5) }} ‎&euro;</td>
                                                <td id="all_tav">{{ round($total_actual_value, 5); }} &euro;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped color-bordered-table primary-bordered-table table-info">
                                        <thead>
                                            <tr>
                                                <th class="col-dark">Swimlane Distribution</th>
                                                <th class="col-dark text-right">11,665 ‎&euro;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Cashback matrix</td>
                                                <td class="text-right">10 ‎&euro;</td>
                                            </tr>
                                            <tr>
                                                <td>PS</td>
                                                <td class="text-right">0,165 ‎&euro;</td>
                                            </tr>
                                            <tr>
                                                <td>Corporate account</td>
                                                <td class="text-right">0,25 ‎&euro;</td>
                                            </tr>
                                            <tr>
                                                <td>Incubator Chain</td>
                                                <td class="text-right">1 ‎&euro;</td>
                                            </tr>
                                            <tr>
                                                <td>Backup cycle</td>
                                                <td class="text-right">0,25 ‎&euro;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane active" id="tab-cb" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-striped color-bordered-table primary-bordered-table table-cb">
                                        <thead>
                                            <tr>
                                                <th class="col-dark">Comms<br>Volume</th>
                                                <th class="col-dark">CB%</th>
                                                <th class="col-dark" colspan="2">Cashback<div class="text-xs">(if volume are met)</div></th>
                                            </tr>
                                            <tr class="subheading">
                                                <th class="col-dark"></th>
                                                <th class="col-dark"></th>
                                                <th class="col-dark">Potential</th>
                                                <th class="col-dark">Filled</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $total_projected_value = 0;
                                            $total_actual_value = 0;
                                        @endphp
                                        @foreach($matrixPercentageArray as $key => $value)
                                            @php
                                                $cashback_percentage = 85.72/100;
                                                $comm_value =  0.25 * $matrixSchemeArray[$key] * $cashback_percentage;
                                                $projected_value = $comm_value * $value/100;
                                                $actual_value = 0.25 * $nodeLevelCounter[$key] * $value/100 * $cashback_percentage;
                                                $total_projected_value += $projected_value;
                                                $total_actual_value += $actual_value;
                                            @endphp
                                            <tr>
                                                <td class="col-dark" id="cb_col1_{{ $key; }}">{{ round($comm_value, 5); }} ‎&euro;</td>
                                                <td class="col-dark" id="cb_col2_{{ $key; }}">{{ round($value, 5); }}%</td>
                                                <td class="col-light" id="cb_col3_{{ $key; }}">{{ round($projected_value, 5); }} ‎&euro;</td>
                                                <td id="cb_col4_{{ $key; }}">{{ round($actual_value, 5); }} ‎&euro;</td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td class="col-dark"></td>
                                                <td class="col-dark">100%</td>
                                                <td class="col-light" id="cb_tpv">{{ round($total_projected_value, 2) }} ‎&euro;</td>
                                                <td id="cb_tav">{{ round($total_actual_value, 2); }} &euro;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-ca" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-striped color-bordered-table primary-bordered-table table-ca">
                                        <thead>
                                            <tr>
                                                <th class="col-dark">Comms<br>Volume</th>
                                                <th class="col-dark">CA%</th>
                                                <th class="col-dark" colspan="2">Cashback<div class="text-xs">(if volume are met)</div></th>
                                            </tr>
                                            <tr class="subheading">
                                                <th class="col-dark"></th>
                                                <th class="col-dark"></th>
                                                <th class="col-dark">Potential</th>
                                                <th class="col-dark">Filled</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $total_projected_value = 0;
                                            $total_actual_value = 0;
                                        @endphp
                                        @foreach($matrixPercentageArray as $key => $value)
                                            @php
                                                $cashback_percentage = 2.1432/100;
                                                $comm_value =  0.25 * $matrixSchemeArray[$key] * $cashback_percentage;
                                                $projected_value = $comm_value * $value/100;
                                                $actual_value = 0.25 * $nodeLevelCounter[$key] * $value/100 * $cashback_percentage;
                                                $total_projected_value += $projected_value;
                                                $total_actual_value += $actual_value;
                                            @endphp
                                            <tr>
                                                <td class="col-dark" id="ca_col1_{{ $key; }}">{{ round($comm_value, 5); }} ‎&euro;</td>
                                                <td class="col-dark" id="ca_col2_{{ $key; }}">{{ round($value, 5); }}%</td>
                                                <td class="col-light" id="ca_col3_{{ $key; }}">{{ round($projected_value, 5); }} ‎&euro;</td>
                                                <td id="ca_col4_{{ $key; }}">{{ round($actual_value, 5); }} ‎&euro;</td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td class="col-dark"></td>
                                                <td class="col-dark">100%</td>
                                                <td class="col-light" id="ca_tpv">{{ round($total_projected_value, 5) }} ‎&euro;</td>
                                                <td id="ca_tav">{{ round($total_actual_value, 5); }} &euro;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-ic" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-striped color-bordered-table primary-bordered-table table-ic">
                                        <thead>
                                            <tr>
                                                <th class="col-dark">Comms<br>Volume</th>
                                                <th class="col-dark">IC%</th>
                                                <th class="col-dark" colspan="2">Cashback<div class="text-xs">(if volume are met)</div></th>
                                            </tr>
                                            <tr class="subheading">
                                                <th class="col-dark"></th>
                                                <th class="col-dark"></th>
                                                <th class="col-dark">Potential</th>
                                                <th class="col-dark">Filled</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $total_projected_value = 0;
                                            $total_actual_value = 0;
                                        @endphp
                                        @foreach($matrixPercentageArray as $key => $value)
                                            @php
                                                $cashback_percentage = 8.5726/100;
                                                $comm_value =  0.25 * $matrixSchemeArray[$key] * $cashback_percentage;
                                                $projected_value = $comm_value * $value/100;
                                                $actual_value = 0.25 * $nodeLevelCounter[$key] * $value/100 * $cashback_percentage;
                                                $total_projected_value += $projected_value;
                                                $total_actual_value += $actual_value;
                                            @endphp
                                            <tr>
                                                <td class="col-dark" id="ic_col1_{{ $key; }}">{{ round($comm_value, 5); }} ‎&euro;</td>
                                                <td class="col-dark" id="ic_col2_{{ $key; }}">{{ round($value, 5); }}%</td>
                                                <td class="col-light" id="ic_col3_{{ $key; }}">{{ round($projected_value, 5); }} ‎&euro;</td>
                                                <td id="ic_col4_{{ $key; }}">{{ round($actual_value, 5); }} ‎&euro;</td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td class="col-dark"></td>
                                                <td class="col-dark">100%</td>
                                                <td class="col-light" id="ic_tpv">{{ round($total_projected_value, 2) }} ‎&euro;</td>
                                                <td id="ic_tav">{{ round($total_actual_value, 2); }} &euro;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-bc" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-striped color-bordered-table primary-bordered-table table-bc">
                                        <thead>
                                            <tr>
                                                <th class="col-dark">Comms<br>Volume</th>
                                                <th class="col-dark">BC%</th>
                                                <th class="col-dark" colspan="2">Cashback<div class="text-xs">(if volume are met)</div></th>
                                            </tr>
                                            <tr class="subheading">
                                                <th class="col-dark"></th>
                                                <th class="col-dark"></th>
                                                <th class="col-dark">Potential</th>
                                                <th class="col-dark">Filled</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $total_projected_value = 0;
                                            $total_actual_value = 0;
                                        @endphp
                                        @foreach($matrixPercentageArray as $key => $value)
                                            @php
                                                $cashback_percentage = 2.1432/100;
                                                $comm_value =  0.25 * $matrixSchemeArray[$key] * $cashback_percentage;
                                                $projected_value = $comm_value * $value/100;
                                                $actual_value = 0.25 * $nodeLevelCounter[$key] * $value/100 * $cashback_percentage;
                                                $total_projected_value += $projected_value;
                                                $total_actual_value += $actual_value;
                                            @endphp
                                            <tr>
                                                <td class="col-dark" id="bc_col1_{{ $key; }}">{{ round($comm_value, 5); }} ‎&euro;</td>
                                                <td class="col-dark" id="bc_col2_{{ $key; }}">{{ round($value, 5); }}%</td>
                                                <td class="col-light" id="bc_col3_{{ $key; }}">{{ round($projected_value, 5); }} ‎&euro;</td>
                                                <td id="bc_col4_{{ $key; }}">{{ round($actual_value, 5); }} ‎&euro;</td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td class="col-dark"></td>
                                                <td class="col-dark">100%</td>
                                                <td class="col-light" id="bc_tpv">{{ round($total_projected_value, 5) }} ‎&euro;</td>
                                                <td id="bc_tav">{{ round($total_actual_value, 5); }} &euro;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="page-content-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#level_tab" role="tab">
                                            <span class="hidden-sm-up"><i class="ti-home"></i></span>
                                            <span class="hidden-xs-down">Matrix Viewer</span>
                                        </a>
                                    </li>
                                    {{--<li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#software_license_tab" id="software_license_link" role="tab">
                                            <span class="hidden-sm-up"><i class="ti-home"></i></span>
                                            <span class="hidden-xs-down">Software License</span>
                                        </a>
                                    </li>--}}
                                </ul>
                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active" id="level_tab" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-8 col-xl-9">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="switchery-demo mb2-xs text-center"> 8
                                                                    <span class="ml-2 mr-2"><input type="checkbox" class="js-switch" value="13" data-color="#ee5ea6" data-secondary-color="#1ca3ff" /></span> 12
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select class="js-example-type form-control" name="type">
                                                                    <option value="All">Select Type</option>
                                                                    @foreach(App\Models\UserPositionAccount::TYPE_SELECT as $key => $label)
                                                                        <option value="{{ $label }}">{{ $label }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select class="js-example-basic-single form-control" name="state"></select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button id="parentNode" type="button" class="btn-sm btn-primary">Go to Parent</button>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="alert alert-info" style="display: none;" id="infoMessage">
                                                                <h5>This node does not have any child nodes to render</h5>
                                                            </div>
                                                        </div>
                                                        <div class="matrixviewer">
                                                            <div class="fibonacci">
                                                                <div class="loader" style="display: none; margin-bottom: 5%; margin-left: 35%; margin-right: auto; padding: inherit; width: 100px;">
                                                                    <svg class="circular" viewBox="25 25 50 50">
                                                                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                                                                    </svg>
                                                                </div>
                                                                <svg class="fibonacci__svg fibonacci__svg--radial" width="600" height="600"></svg>
                                                                <div class="fibonacci__tooltip"></div>
                                                                <ul class="legend" style="width: unset;">
                                                                    <li><span class="self_nodes"></span>User Nodes</li>
                                                                    <li><span class="else_nodes"></span>Empty Nodes</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-xl-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped color-bordered-table primary-bordered-table table-matrixviewer">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="col-dark">Level</th>
                                                                        <th class="col-dark" colspan="2">Nodes</th>
                                                                    </tr>
                                                                    <tr class="subheading">
                                                                        <th class="col-dark"></th>
                                                                        <th class="col-dark">Total</th>
                                                                        <th class="col-dark">Filled</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($matrixSchemeArray as $i => $value)
                                                                    <tr>
                                                                        <td class="col-dark">{{ $i; }}</td>
                                                                        <td class="col-light">{{ $value; }}</td>
                                                                        <td id="level_{{ $i; }}">{{ $nodeLevelCounter[$i]; }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                    <tr>
                                                                        <td class="col-dark"></td>
                                                                        <td class="col-light">376</td>
                                                                        <td id="sum">{{ array_sum($nodeLevelCounter); }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="tab-pane" id="software_license_tab" role="tabpanel">
                                        <div class="row mt-2">
                                            <div class="col-md-8">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">First Level Users</h4>
                                                        <h6 class="card-subtitle">Users that were directly registered through your affiliate link</h6>
                                                        <table id="demo-foo-row-toggler" class="table toggle-circle table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th data-toggle="true"> Name</th>
                                                                    <th>Clients</th>
                                                                    <th>Licenses</th>
                                                                    <th data-hide="all"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($finalDataArr as $item)
                                                                <tr>
                                                                    <td>{{ $item['name']; }}<br>
                                                                        <small class="text-muted" style="margin-left: 25px">{{ $item['email']; }}</small>
                                                                    </td>
                                                                    <td>{{ $item['client_count']; }}</td>
                                                                    <td>{{ $item['license_count']; }}/<span style="font-size: larger; color: #28a745">{{ $item['active_license_count']; }}</span></td>
                                                                    <td>
                                                                        <div class="row" style="margin-left: 15px;">
                                                                            @if(!empty($item['inner_level']))
                                                                                <div class="col-md-12">
                                                                                    <div class="card">
                                                                                        <div class="card-body">
                                                                                            <h4 class="card-title">Level 2 Node Details</h4>
                                                                                            <h6 class="card-subtitle">Level 1 users of {{ $item['name']; }}</h6>
                                                                                            <div class="profiletimeline m-t-40">
                                                                                                @foreach ($item['inner_level'] as $levelTwo)
                                                                                                    <div class="sl-item">
                                                                                                        <div class="sl-left">
                                                                                                            <img src="{{ asset('img/male-user.png') }}" alt="user" class="img-circle" style="max-width:40px;">
                                                                                                        </div>
                                                                                                        <div class="sl-right">
                                                                                                            <div><a href="#" class="link">{{ $levelTwo['name']; }}</a>
                                                                                                                <div class="like-comm" style="margin: 20px">
                                                                                                                    <span class="m-b-10" style="font-size: larger; padding-right: 30px"><i class="fa fa-users text-danger fa-lg"></i> Total Clients: {{ $levelTwo['client_count']; }}</span>
                                                                                                                    <span class="m-b-10" style="font-size: larger; padding-right: 30px"><i class="fa fa-id-card text-warning fa-lg"></i> Total Licenses: {{ $levelTwo['license_count']; }}</span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <p>No Clients have been added yet.</p>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                            @if(count($finalDataArr) > 10)
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <div class="text-right">
                                                                                <ul class="pagination pagination-split m-t-30"> </ul>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card card-outline-info">
                                                    <div class="card-header">
                                                        <h4 class="m-b-0 text-white text-center">CBM Licenses</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <blockquote>
                                                            <p class="card-text text-primary" style="font-size: large">First Tier Clients: <strong style="font-size: larger">{{ $firstTierClients; }}</strong></p>
                                                            <p class="card-text" style="font-size: large; color: #28a745">First Tier Licenses: <strong style="font-size: larger">{{ $firstTierLicenses; }}</strong></p>
                                                        </blockquote>
                                                        <blockquote>
                                                            <p class="card-text text-primary" style="font-size: large">Second Tier Clients: <strong style="font-size: larger">{{ $secondTierClients; }}</strong></p>
                                                            <p class="card-text" style="font-size: large; color: #28a745">Second Tier Licenses: <strong style="font-size: larger">{{ $secondTierLicenses; }}</strong></p>
                                                        </blockquote>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="https://d3js.org/d3.v5.min.js"></script>
<script type="text/javascript" src="https://d3js.org/d3-dsv.v1.min.js"></script>
<script type="text/javascript" src="https://d3js.org/d3-fetch.v1.min.js"></script>
<script src="{{ asset('js/radial/fibonacci-tree.min.js') }}"></script>
<script src="{{ asset('js/radial/switchery.min.js') }}"></script>
<script src="{{ asset('js/radial/tree-generator.min.js') }}"></script>
{{--<script src="{{ asset('js/radial/footable.all.min.js') }}"></script>--}}
<script type="text/javascript">
    var matrixDataJson;
    /*
    * Fibonacci tree development
    * */
    function developRadialTree(developLevels) {
        if(matrixDataJson.length > 0){
            const toCsvArray = (d) => ({
                id: +d.id,
                accountNo: d.cbm_account_num,
                userId: d.user_id,
                email: d.email,
                lchild: +d.lchild,
                rchild: +d.rchild,
            });
            const svgRadial = d3.select(".fibonacci__svg--radial");
            const tooltip = d3.select(".fibonacci__tooltip");
            const margin = { x: 50, y: 50 };

            new FibonacciTree(matrixDataJson, svgRadial, tooltip, { levels: developLevels, isRadial: true, margin });
        }else{
            $('#infoMessage').show().delay(5000).fadeOut();
        }
    }

    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "{{ route('frontend.radial.matrixData') }}",
            data: {
                accountNum: null
            },
            beforeSend:function () {
                $('.loader').css('display','block');
            },
            success: function (response) {
                if(response.status == 1){
                    matrixDataJson = response.data;
                    //Default radial tree
                    developRadialTree(window.nextLevels);
                }else{
                    toastr.error(response.message);
                }
            },
            complete: function(){
                $('.loader').css('display','none');
            }
        });

        $('.js-example-type').select2();
        $('.js-example-basic-single').select2();
        nodeType();

        // Switchery
        window.nextLevels = 9;
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
        $('.js-switch').on('change', function () {
            if($(this).prop('checked') === true){
                window.nextLevels = 13;
            }else{
                window.nextLevels = 9;
            }
            //remove the tree first
            $('.fibonacci__svg').empty();
            developRadialTree(window.nextLevels);
        });
    });

    //Develop Radial Tree on node change
    $(document).on('change', '.js-example-basic-single', function () {
        let newNode = $(this).val();
        developNodeTree(newNode);
    });

    //Develop Radial Tree for selected node
    function developNodeTree(node){
        $("#pNode").empty();
        $.ajax({
            type: "POST",
            url: "{{ route('frontend.radial.matrixData') }}",
            data: {
                accountNum: node
            },
            beforeSend:function () {
                $('.loader').css('display','block');
            },
            success: function (response) {
                if(response.status == 1){
                    matrixDataJson = response.data;
                    let nodeLevelCounter = response.nodeLevelCounter;
                    let matrixSchemeArray = response.matrixSchemeArray;
                    let matrixPercentageArray = response.matrixPercentageArray;

                    //remove the tree first
                    $('.fibonacci__svg').empty();
                    developRadialTree(window.nextLevels);

                    $('.loader').css('display','none');
                    //update node level
                    let total = 0;
                    $.each(nodeLevelCounter, function (key, value) {
                        $('#level_'+key).html(value);
                        total = total + value;
                    });
                    $('#sum').html(total);

                    let all_total_projected_value = 0;
                    let all_total_actual_value = 0;
                    let cb_total_projected_value = 0;
                    let cb_total_actual_value = 0;
                    let ca_total_projected_value = 0;
                    let ca_total_actual_value = 0;
                    let ic_total_projected_value = 0;
                    let ic_total_actual_value = 0;
                    let bc_total_projected_value = 0;
                    let bc_total_actual_value = 0;
                    $.each(matrixPercentageArray, function (k, v) {
                        //calculation for all nodes
                        let all_comm_value =  0.25 * matrixSchemeArray[k];
                        let all_projected_value = all_comm_value * v/100;
                        let all_actual_value = 0.25 * nodeLevelCounter[k] * v / 100;
                        all_total_projected_value += all_projected_value;
                        all_total_actual_value += all_actual_value;

                        $('#all_col1_'+k).html(all_comm_value.toFixed(2)+' ‎&euro;');
                        $('#all_col2_'+k).html(v+' ‎%');
                        $('#all_col3_'+k).html(all_projected_value.toFixed(2)+' ‎&euro;');
                        $('#all_col4_'+k).html(all_actual_value.toFixed(2)+' ‎&euro;');

                        //calculation for cashback matrix nodes
                        let cashback_percentage = 85.72/100;
                        let cb_comm_value =  0.25 * matrixSchemeArray[k] * cashback_percentage;
                        let cb_projected_value = cb_comm_value * v/100;
                        let cb_actual_value = 0.25 * nodeLevelCounter[k] * v / 100 * cashback_percentage;
                        cb_total_projected_value += cb_projected_value;
                        cb_total_actual_value += cb_actual_value;

                        $('#cb_col1_'+k).html(cb_comm_value.toFixed(5)+' ‎&euro;');
                        $('#cb_col2_'+k).html(v+' ‎%');
                        $('#cb_col3_'+k).html(cb_projected_value.toFixed(5)+' ‎&euro;');
                        $('#cb_col4_'+k).html(cb_actual_value.toFixed(5)+' ‎&euro;');

                        //calculation for corporate account nodes
                        let ca_percentage = 2.1432/100;
                        let ca_comm_value =  0.25 * matrixSchemeArray[k] * ca_percentage;
                        let ca_projected_value = ca_comm_value * v/100;
                        let ca_actual_value = 0.25 * nodeLevelCounter[k] * v / 100 * ca_percentage;
                        ca_total_projected_value += ca_projected_value;
                        ca_total_actual_value += ca_actual_value;

                        $('#ca_col1_'+k).html(ca_comm_value.toFixed(5)+' ‎&euro;');
                        $('#ca_col2_'+k).html(v+' ‎%');
                        $('#ca_col3_'+k).html(ca_projected_value.toFixed(5)+' ‎&euro;');
                        $('#ca_col4_'+k).html(ca_actual_value.toFixed(5)+' ‎&euro;');

                        //calculation for incubatot chain nodes
                        let ic_percentage = 8.5726/100;
                        let ic_comm_value =  0.25 * matrixSchemeArray[k] * ic_percentage;
                        let ic_projected_value = ic_comm_value * v/100;
                        let ic_actual_value = 0.25 * nodeLevelCounter[k] * v / 100 * ic_percentage;
                        ic_total_projected_value += ic_projected_value;
                        ic_total_actual_value += ic_actual_value;

                        $('#ic_col1_'+k).html(ic_comm_value.toFixed(5)+' ‎&euro;');
                        $('#ic_col2_'+k).html(v+' ‎%');
                        $('#ic_col3_'+k).html(ic_projected_value.toFixed(5)+' ‎&euro;');
                        $('#ic_col4_'+k).html(ic_actual_value.toFixed(5)+' ‎&euro;');

                        //calculation for backup cycle nodes
                        let bc_percentage = 2.1432/100;
                        let bc_comm_value =  0.25 * matrixSchemeArray[k] * bc_percentage;
                        let bc_projected_value = bc_comm_value * v/100;
                        let bc_actual_value = 0.25 * nodeLevelCounter[k] * v / 100 * bc_percentage;
                        bc_total_projected_value += bc_projected_value;
                        bc_total_actual_value += bc_actual_value;

                        $('#bc_col1_'+k).html(bc_comm_value.toFixed(5)+' ‎&euro;');
                        $('#bc_col2_'+k).html(v+' ‎%');
                        $('#bc_col3_'+k).html(bc_projected_value.toFixed(5)+' ‎&euro;');
                        $('#bc_col4_'+k).html(bc_actual_value.toFixed(5)+' ‎&euro;');
                    });
                    //All nodes total
                    $('#all_tpv').html(all_total_projected_value.toFixed(5)+' ‎&euro;');
                    $('#all_tav').html(all_total_actual_value.toFixed(5)+' ‎&euro;');

                    //Cashback matrix nodes total
                    $('#cb_tpv').html(cb_total_projected_value.toFixed(5)+' ‎&euro;');
                    $('#cb_tav').html(cb_total_actual_value.toFixed(5)+' ‎&euro;');

                    //Corporate account nodes total
                    $('#ca_tpv').html(ca_total_projected_value.toFixed(5)+' ‎&euro;');
                    $('#ca_tav').html(ca_total_actual_value.toFixed(5)+' ‎&euro;');

                    //Incubatot chain nodes total
                    $('#ic_tpv').html(ic_total_projected_value.toFixed(5)+' ‎&euro;');
                    $('#ic_tav').html(ic_total_actual_value.toFixed(5)+' ‎&euro;');

                    //Backup cycle nodes total
                    $('#bc_tpv').html(bc_total_projected_value.toFixed(5)+' ‎&euro;');
                    $('#bc_tav').html(bc_total_actual_value.toFixed(5)+' ‎&euro;');
                }else{
                    toastr.error(response.message);
                }
            }
        });
    }

    /* fetch user account number by type */
    function nodeType(i){
        $("#pNode").empty();
        let type = $(".js-example-type").val();
        $.ajax({
            type: "POST",
            url: "{{ route('frontend.radial.allNode') }}",
            data: {
                type: type
            },
            beforeSend:function () {
                $('.loader').css('display','block');
            },
            success: function (response) {
                $('.loader').css('display','none');
                if(response.status == 1){
                    let allNodeData = response.data;
                    $.each(allNodeData, function (key, value) {
                        $('.js-example-basic-single').select2().append('<option value="' + value + '">' + value + '</option>');
                    });

                    //Develop Radial Tree on node type change
                    if(i == 1){
                        let newNode = $('.js-example-basic-single').val();
                        developNodeTree(newNode);
                    }
                }
            }
        });
    }

    $(document).on('change', '.js-example-type', function () {
        $('.js-example-basic-single').select2().empty();
        nodeType(1);
    });

    $("#parentNode").click(function(){
        let nodeNum = $(".js-example-basic-single").val();
        $.ajax({
            type: "POST",
            url: "{{ route('frontend.radial.goToParent') }}",
            data: {
                nodeNum: nodeNum
            },
            beforeSend:function () {
                $('.loader').css('display','block');
            },
            success: function (response) {
                $('.loader').css('display','none');
                if(response.status == 1){
                    developNodeTree(response.data);
                    $(".js-example-basic-single").val(response.data);
                    $("#infoMessage").show().html("Parent view for "+response.data);
                }else{
                    toastr.info(response.message);
                }
            }
        });
    });

    //After d3 functionality, nodeClick would be called for updating the table
    function nodeClick(e) {
        $("#pNode").empty();
        $.ajax({
            type: "POST",
            url: "{{ route('frontend.radial.calculateNodeChild') }}",
            data: {
                nodeId: e
            },
            success: function (response) {
                if(response.status == 1){
                    let nodeLevelData = response.data;
                    $.each(nodeLevelData, function (key, value) {
                        $('#level_'+key).html(value);
                    })
                }else{
                    toastr.error(response.message);
                }
            }
        });
    }

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        if($('#wrapper').hasClass('toggled')){
            //Closed state
            localStorage['rightPanel'] = 0;
        } else {
            //Open state
            localStorage['rightPanel'] = 1;
        }
    });

    /*$('#demo-foo-row-toggler').footable();
    $('#demo-foo-row-toggler').change(function (e) {
        e.preventDefault();
        let pageSize = 10;
        $('#demo-foo-row-toggler').data('page-size', pageSize);
        $('#demo-foo-row-toggler').trigger('footable_initialized');
    });
    $('.nav-tabs a').on('shown.bs.tab', function () {
        $('.footable').trigger('footable_resize');
    });*/
</script>
@endsection

