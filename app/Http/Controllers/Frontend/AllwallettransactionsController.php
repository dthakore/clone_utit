<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAllwallettransactionRequest;
use App\Http\Requests\StoreAllwallettransactionRequest;
use App\Http\Requests\UpdateAllwallettransactionRequest;
use App\Models\Allwallettransaction;
use App\Models\Denomination;
use App\Models\User;
use App\Models\WalletMetaType;
use App\Models\WalletType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\WalletHelper;
use GuzzleHttp\Client;

class AllwallettransactionsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('allwallettransaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allwallettransactions = Allwallettransaction::with(['user', 'wallet_type', 'reference', 'denomination'])->get();

        $users = User::get();

        $wallet_types = WalletType::get();

        $wallet_meta_types = WalletMetaType::get();

        $denominations = Denomination::get();

        return view('frontend.allwallettransactions.index', compact('allwallettransactions', 'users', 'wallet_types', 'wallet_meta_types', 'denominations'));
    }

    public function create()
    {
        abort_if(Gate::denies('allwallettransaction_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $wallet_types = WalletType::pluck('wallet_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $references = WalletMetaType::pluck('reference_desc', 'id')->prepend(trans('global.pleaseSelect'), '');

        $denominations = Denomination::pluck('denomination_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.allwallettransactions.create', compact('users', 'wallet_types', 'references', 'denominations'));
    }

    public function store(StoreAllwallettransactionRequest $request)
    {
        $allwallettransaction = Allwallettransaction::create($request->all());

        return redirect()->route('frontend.allwallettransactions.index');
    }

    public function edit(Allwallettransaction $allwallettransaction)
    {
        abort_if(Gate::denies('allwallettransaction_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $wallet_types = WalletType::pluck('wallet_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $references = WalletMetaType::pluck('reference_desc', 'id')->prepend(trans('global.pleaseSelect'), '');

        $denominations = Denomination::pluck('denomination_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $allwallettransaction->load('user', 'wallet_type', 'reference', 'denomination');

        return view('frontend.allwallettransactions.edit', compact('users', 'wallet_types', 'references', 'denominations', 'allwallettransaction'));
    }

    public function update(UpdateAllwallettransactionRequest $request, Allwallettransaction $allwallettransaction)
    {
        $allwallettransaction->update($request->all());

        return redirect()->route('frontend.allwallettransactions.index');
    }

    public function show(Allwallettransaction $allwallettransaction)
    {
        abort_if(Gate::denies('allwallettransaction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allwallettransaction->load('user', 'wallet_type', 'reference', 'denomination');

        return view('frontend.allwallettransactions.show', compact('allwallettransaction'));
    }

    public function destroy(Allwallettransaction $allwallettransaction)
    {
        abort_if(Gate::denies('allwallettransaction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allwallettransaction->delete();

        return back();
    }

    public function massDestroy(MassDestroyAllwallettransactionRequest $request)
    {
        Allwallettransaction::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Display Wallet Details
     * */
    public function wallet()
    {
        setlocale(LC_MONETARY, 'nl_NL.UTF-8');
        $userId = Auth::id();
        $userWallet = WalletType::where(['wallet_type' => 'User'])->first();
        $walletType = isset($userWallet->id) ? $userWallet->id : '';

        //To calculate max Balance
        $walletData = Allwallettransaction::select(DB::raw('SUM(CASE WHEN transaction_type = 1 THEN amount ELSE 0 END) AS credit_amt'))
            ->where(['user_id' => $userId, 'wallet_type_id' => $walletType])
            ->first();
        $maxBalance = isset($walletData['credit_amt']) ? $walletData['credit_amt'] : 0;

        //Credit amount minus Debit amount
        $balance = WalletHelper::getUserWalletEarnings($userId);

        //Reserve Wallet Earnings
        $reserve_balance = WalletHelper::getReserveWalletBalance($userId);

        //Total Payouts
        $payout_reference = WalletMetaType::where(['reference_key' => 'Payout'])->first();
        $payoutReference = isset($payout_reference->id) ? $payout_reference->id : '';

        $payoutRef = Allwallettransaction::where(['user_id' => $userId, 'wallet_type_id' => $walletType, 'transaction_type' => 2, 'reference_id' => $payoutReference])
            ->sum('amount');
        $totalPayouts = isset($payoutRef) ? $payoutRef : 0;

        $affiliate_reference = WalletMetaType::where(['reference_key' => 'Affiliate Commission'])->first();
        $affiliateReference = isset($affiliate_reference->id) ? $affiliate_reference->id : '';

        //All wallet transactions
        $allwallettransactions = Allwallettransaction::with(['user', 'wallet_type', 'reference', 'denomination'])->where('user_id','=',Auth::id())->get();

        //QR code
        $qrCode = Allwallettransaction::whereNotNull('payment_id')->where('user_id','=',Auth::id())->orderBy('id', 'desc')->first();
        
        //Affiliate wallet transactions
        $affiliate_wallet = Allwallettransaction::where(['user_id' => $userId, 'wallet_type_id' => $walletType, 'reference_id' => $affiliateReference])
            ->orderByDesc('created_at')
            ->get();

        //Wallet commission
        $commission_references = WalletMetaType::where('reference_key', 'LIKE', '%Commission Transactions-%')->get();
        $cashback_references = [];
        foreach ($commission_references as $commission){
            array_push($cashback_references, $commission->id);
        }

        $cashback_wallet = Allwallettransaction::where(['user_id' => $userId, 'wallet_type_id' => $walletType, 'transaction_type' => 1])
            ->whereIn('reference_id', $cashback_references)
            ->orderByDesc('created_at')
            ->get();
        //payout wallet
        $payout_wallet = Allwallettransaction::where(['user_id' => $userId, 'wallet_type_id' => $walletType, 'transaction_type' => 2, 'reference_id' => $payoutReference])
            ->orderByDesc('created_at')
            ->get();
        //order payment wallet transactions
        $wallet_reference = WalletMetaType::where(['reference_key' => 'Wallet Transactions'])->first();
        $walletReference = isset($wallet_reference->id) ? $wallet_reference->id : '';

        $reserveWallet = WalletType::where(['wallet_type' => 'Reserve Wallet'])->first();
        $reserveType = isset($reserveWallet->id) ? $reserveWallet->id : '';

        $order_payment = Allwallettransaction::where(['user_id' => $userId, 'transaction_type' => 2, 'reference_id' => $walletReference])
            ->whereIn('wallet_type_id', [$walletType, $reserveType])
            ->orderByDesc('created_at')
            ->get();
        //echo '<pre>';print_r($payout_wallet);die;
        return view('frontend.allwallettransactions.wallet', compact('balance', 'maxBalance', 'totalPayouts', 'reserve_balance', 'allwallettransactions', 'affiliate_wallet', 'cashback_wallet', 'payout_wallet', 'order_payment', 'qrCode'));
    }

    public function addFundsToWallet(Request $request)
    {
        $inputs = $request->all();

        $userId = Auth::id();
        $userWallet = WalletType::where(['wallet_type' => 'User'])->first();
        $wallet_reference = WalletMetaType::where(['reference_key' => 'self-funding'])->first();

        $client = new Client();
        $response = $client->request('POST', 'https://api.sandbox.nowpayments.io/v1/payment',[
            'headers' => [
                'x-api-key' => env('NOW_API'),
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'price_amount' => $inputs['amount'],
                'price_currency' => $inputs['currency'],
                'pay_amount' => $inputs['amount'],
                'pay_currency' => 'btc',
                'ipn_callback_url' => url('/').'/webhook/nowpayment',
                'order_id' => 'RGDBP-122224',
                'order_description' => 'Test',
                'case' => 'success',
            ],
        ]);
        $statusCode = $response->getStatusCode();
        $body = json_decode($response->getBody()->getContents(), true);

        $data['transaction_type'] = 1;
        $data['reference_num'] = 1;
        $data['transaction_comment'] = isset($wallet_reference->reference_desc) ? $wallet_reference->reference_desc : '';
        $data['transaction_status'] = 1;
        $data['amount'] = $body['price_amount'];
        $data['user_id'] = $userId;
        $data['wallet_type_id'] = isset($userWallet->id) ? $userWallet->id : '';
        $data['reference_id'] = isset($wallet_reference->id) ? $wallet_reference->id : '';
        $data['denomination_id'] = 1;
        $data['payment_id'] = $body['payment_id'];
        $data['pay_address'] = $body['pay_address'];
        $data['purchase_id'] = $body['purchase_id'];
        $data['created_at'] = now();

        $insert = Allwallettransaction::insert($data);
        if ($insert) {
            return response()->json(["status" => 1, "message" => "Funds added successfully"]);
        } else {
            return response()->json(["status" => 0, "message" => "Failed to add funds"]);
        }
    }
}
