@extends('layouts.master')

@section('content')
    <shop-component
        endpoint="{{ route('carts.cart.index') }}"
        ></shop-component>
@endsection
