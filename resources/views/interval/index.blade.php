@extends('template.master')

@section('title', 'Ajustes')

@section('content-css')
<link rel="stylesheet" href="{{ asset('css/interval.css') }}"> 
@endsection

@section('content')
<form action="{{ route('setInterval') }}" method="post">
    @csrf
    <div class="row row-interval">
        <div class="col-md-12 d-flex justify-content-center align-items-center mt-5">
            <span class="title-interval">Notificar a falta de conexão a cada:</span> 
        </div>
        <div class="col-md-12 d-flex justify-content-center align-items-center mb-5">
            <span class="title-interval">{{$interval}}</span> 
        </div>
        <div class="col-md-4 offset-md-4 d-flex justify-content-center align-items-center col-title">
            <input class="form-control" type="time" min="00:00:06" step="1" name="time" id="" required>
            <button class="btn btn-interval" type="submit">Alterar</button>
        </div>
    </div>
</form>

@if (Session::has('success'))
    <div class="row d-flex justify-content-center mt-5">
        <div class="alert alert-light alert-dismissible fade show w-50" role="alert">
            <strong>{{ Session::get('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@endsection

@section('content-js')
@endsection