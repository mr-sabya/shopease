@extends('layouts.app')

@section('content')
<livewire:deal.manage dealId="{{ $dealId }}" />
@endsection