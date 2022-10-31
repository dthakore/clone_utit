@extends('layouts.admin')
@section('content')
    <bot-form
        user-exchanges="{{ json_encode($user_exchanges->toArray()) }}"
        symbols="{{ json_encode($symbols->toArray()) }}"
        user-id="{{ $bot->user_id }}"
        bot="{{ $bot }}"
        reserved-balance="{{ \App\Helpers\Helper::botReserved() }}"
    ></bot-form>
@endsection
