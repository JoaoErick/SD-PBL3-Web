@extends('template.master')

@section('title', 'Home')

@section('content-css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}"> 
@livewireStyles
@endsection

@section('content')
<livewire:show-connection />
@endsection

@section('content-js')
@livewireScripts
@endsection