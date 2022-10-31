@extends('layouts.frontend')
@section('content')
    <bot-list
        allowed-bots="{{ \App\Helpers\Helper::productMeta('trading-pairs') }}"
        wallet-balance="{{ \App\Helpers\Helper::walletBalance() }}"
    ></bot-list>
@endsection
