<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAllwallettransactionRequest;
use App\Http\Requests\UpdateAllwallettransactionRequest;
use App\Http\Resources\Admin\AllwallettransactionResource;
use App\Models\Allwallettransaction;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllwallettransactionsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('allwallettransaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AllwallettransactionResource(Allwallettransaction::with(['user', 'wallet_type', 'reference', 'denomination'])->get());
    }

    public function store(StoreAllwallettransactionRequest $request)
    {
        $allwallettransaction = Allwallettransaction::create($request->all());

        return (new AllwallettransactionResource($allwallettransaction))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Allwallettransaction $allwallettransaction)
    {
        abort_if(Gate::denies('allwallettransaction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AllwallettransactionResource($allwallettransaction->load(['user', 'wallet_type', 'reference', 'denomination']));
    }

    public function update(UpdateAllwallettransactionRequest $request, Allwallettransaction $allwallettransaction)
    {
        $allwallettransaction->update($request->all());

        return (new AllwallettransactionResource($allwallettransaction))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Allwallettransaction $allwallettransaction)
    {
        abort_if(Gate::denies('allwallettransaction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allwallettransaction->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function nowPayment(Request $request)
    {
        try{
            $response = [];
            $inputs = $request->all();
            if(isset($inputs['payment_id'])){
                if(in_array($inputs['payment_status'], ["waiting", "confirming", "confirmed", "sending"])){
                    $status = 1; //Pending
                }elseif(in_array($inputs['payment_status'], ["partially_paid", "finished"])){
                    $status = 3; //Approved
                }elseif(in_array($inputs['payment_status'], ["failed", "refunded", "expired"])){
                    $status = 4; //Rejected
                }
                $wallet = Allwallettransaction::where('payment_id', $inputs['payment_id'])->first();
                if(isset($wallet)){
                    $update = Allwallettransaction::where('payment_id', $inputs['payment_id'])
                                        ->update([
                                            'transaction_status' => $status,
                                            'updated_at' => now(),
                                        ]);
                }
                $response['status'] = true;
                $response['message'] = "Payment status updated";
            }
            return response()->json($response);
        }catch(\Exception $error){
            return response()->json([
                'status' => false,
                'error' => $error->getMessage()
            ]);
        }
    }
}
