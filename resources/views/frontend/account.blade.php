@extends('layouts.cashbackfrontend', [
    "title" => "MT4 Accounts",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "/"
        ],
        [
            "title" => "MT4 Accounts"
        ]
    ]
])
<style>
    .subAccountRow{
        display: none;
    }
    .content-wrapper{
        height: auto !important;
    }
    .tableRowVisible{
        display: table-row !important;
    }
</style>
@section('content')
    <div class="">
        <div class="card">
        @if(!$mt_four_user->isEmpty())
            <div class="card-body ">
            <div class="panel-group1" id="accordion11" role="tablist">
                @foreach($mt_four_user as $mtUser)
                <?php
                $accounts = App\Models\UserPositionAccount::where('login', $mtUser->login)->get();
                
                ?>
                <div class="card overflow-hidden">
                    <a class="accordion-toggle panel-heading1 collapsed " data-bs-toggle="collapse" data-bs-parent="#accordion11" href="#collapseFour{{ $loop->index }}" aria-expanded="false">
                        MT4 Account: {{$mtUser->login}} 
                        <span class="ml-5">Balance: {{$mtUser->balance}}</span>
                    </a>
                    <div id="collapseFour{{ $loop->index}}" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
                        <div class="panel-body">
                        <div class="p-0 table-responsive">
                            @if(!$accounts->isEmpty())
                            <table class="table mg-b-0 text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th >{{ trans('cruds.userPositionAccount.fields.user_account_num') }}</th>
                                            <th >{{ trans('cruds.userPositionAccount.fields.email_address') }}</th>
                                            <th >{{ trans('cruds.userPositionAccount.fields.balance') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($accounts as $sub_account)
                                        <tr class="tableRowHide subAccountRow subAccountRow{{$loop->parent->index}}">
                                            <th scope="row">
                                                {{$sub_account->user_account_num}}
                                            </th>
                                            <td>
                                                {{$sub_account->email_address}}
                                            </td>
                                            <td>
                                                {{$sub_account->balance}}
                                            </td>
                                        </tr>
                                    @endforeach     
                                        
                                    </tbody>
                                </table>
                            @if($accounts->count() > 20)
                            <div class="text-center m-3" >
                                <a href = "#" class="btn btn-primary text-center" id = "loadMore{{ $loop->index }}"> Load More </a>
                            </div>
                            @endif
                            @else
                            <div class="text-center m-3" >
                                <p class="btn btn-primary text-center" >No Accounts Found. </p>
                            </div>
                            @endif
                        </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            </div>
        @else
            <div class="card-header">
                <h3 class="card-title">No MT4 Accounts</h3>
            </div>
        @endif
        </div>

    </div>
@endsection
@section('scripts')
@parent
<script>
    $(document).ready (function () {
        var itemToshow = 20;
        @if(!$mt_four_user->isEmpty())
            @foreach($mt_four_user as $mtUser)
                $(".subAccountRow{{ $loop->index }}").slice(0, itemToshow).removeClass('tableRowHide');
                $(".subAccountRow{{ $loop->index }}").slice(0, itemToshow).addClass('tableRowVisible');
                $(".subAccountRow{{ $loop->index }}").slice(0, itemToshow).show();
                
                $("#loadMore{{ $loop->index }}").on("click", function(e){
                    e.preventDefault();
                    $(".tableRowHide").slice(0, itemToshow).addClass('tableRowVisible');
                    $(".tableRowHide").slice(0, itemToshow).removeClass('tableRowHide');
                    $(".tableRowVisible").slice(0, itemToshow).slideDown();
                    if ($(".subAccountRow{{ $loop->index }}:hidden").length == 0) {

                    $("#loadMore{{ $loop->index }}").text("No Account Found ").removeClass('btn-primary').addClass("btn-info");
                    }
                });
            @endforeach
        @endif
    })
</script>
@endsection
