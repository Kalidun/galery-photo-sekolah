@extends('layout.app')

@section('navbar')
  @include('components.navbar')
@endsection

@section('sidebar')
  @include('components.sidebar')
@endsection

@section('content')
  @yield('main-content')
@endsection