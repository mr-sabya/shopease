@extends('layouts.app')

@section('content')
<livewire:product.manage productId="{{ $product->id }}" />
@endsection