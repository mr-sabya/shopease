@extends('layouts.app')

@section('content')
<livewire:blog-post.manage blogPostId="{{ $blogPostId  }}" />
@endsection