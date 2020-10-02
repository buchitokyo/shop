@extends('layouts.master')

@section('content')
    <shop-component
        endpoint="{{ route('cart.index') }}"
    ></shop-component>
@endsection
