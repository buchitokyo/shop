@extends('layouts.master')
@section('content')
    <cart-component
        endpoint="{{ route('payment.form') }}"
        :csrf="{{ json_encode(csrf_token()) }}"
    ></cart-component>
    <!-- :csrf="{{ json_encode(csrf_token()) }}" -->
@endsection
