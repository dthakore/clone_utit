@extends('layouts.frontend-new', [
    "title" => "License List",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "/"
        ],
        [
            "title" => "License"
        ]
    ]
])
@section('styles')

    <!-- Data table css -->
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css')}}"  rel="stylesheet">
    <link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}" rel="stylesheet" />

    <!-- INTERNAL Select2 css -->
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-hover table-bordered text-nowrap border-bottom" id="responsive-datatable">
                            <thead>
                            <tr>
                                <th class="wd-10p">Order ID</th>
                                <th class="wd-25p">Product Name</th>
                                <th class="wd-35p">License Key</th>
                                <th class="wd-15p">Expiry Date</th>
                                <th class="wd-15p">Availability</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subscriptions as $subscription)
                                <tr>
                                    <td>
                                        @php
                                        $order = \App\Models\Order::where(['order' => $subscription->order_id])->first();
                                        @endphp
                                        <a href="{{ url('/order/'.$order->id) }}">{{$subscription->order_id}}</a>
                                    </td>
                                    <td>
                                        <?php
                                        $product_name = \App\Models\Product::where(['id' => $subscription->product_id])->first();
                                        if(isset($product_name)){
                                            echo $product_name->name;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="form-group col-lg-12">
                                            <p class="form-control cpn referral-link" style="font-size: 12px;" id="referral_link{{$loop->index}}" aria-controls="collapse{{$loop->index}}" onclick="Referral('referral_link{{$loop->index}}', '#copied_link{{$loop->index}}')">{{$subscription->licence_key}}</p>
                                            <p id="copied_link{{$loop->index}}" style="color: green"></p>
                                        </div>
                                    </td>
                                    <td>
                                        @if(isset($subscription->cycle_end_at))
                                            {{ date('d-m-Y',strtotime($subscription->cycle_end_at))}}
                                        @endif
                                    </td>
                                    <td>
                                        @if(!is_null($subscription->is_used))
                                            {{App\Models\Subscription::IS_USED[$subscription->is_used]}}
                                        @else
                                            Available
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection
@section('scripts')

    <!-- Internal Data tables -->
    <script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/js/table-data.js')}}"></script>

    <!-- INTERNAL Select2 js -->
    <script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        function Referral(val, copyId) {
            var r = document.createRange();
            r.selectNode(document.getElementById(val));
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(r);
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
            $(copyId).html('Copied!');
        }
    </script>

@endsection

