@extends('layouts.app')

@section('content')
<livewire:customers.manage userId="{{ $userId }}" />
@endsection