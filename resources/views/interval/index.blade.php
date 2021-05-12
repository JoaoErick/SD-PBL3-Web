@extends('template.master')

@section('title', 'Ajustes')

@section('content-css')
<link rel="stylesheet" href="{{ asset('css/interval.css') }}">
<link rel="stylesheet" href="{{ asset('css/switch.css') }}">
@endsection

@section('content')
<form action="{{ route('sync') }}" method="post" id="sync_form" onsubmit="return false">
    @csrf
    <div class="row mt-3">
        <div class="col-12">
            <a class="mx-3 navbar-brand refresh-icon" onclick="document.getElementById('sync_form').submit();">
                <i class="fas fa-sync-alt"></i> Sincronizar
            </a>
        </div>
    </div>
</form>

<form action="{{ route('alarmMode') }}" method="post" id="alarm_form" onsubmit="return false">
    @csrf
    <div class="row row-interval">
        <div class="col-md-12 d-flex justify-content-center align-items-center mt-2">
            <span class="title-interval">Alarme:</span> 
        </div>
        <div class="col-md-12 d-flex justify-content-center align-items-center">
            <label class="form-check-label mx-2" style="color: #fff">
                Acidente
            </label>

            <label class="switch">
                <input type="checkbox" name="mode" onclick="document.getElementById('alarm_form').submit();">
                <span class="slider round"></span>
            </label>

            <label class="form-check-label mx-2" style="color: #fff">
                Furto
            </label>
        </div>
    </div>
</form>

<form action="{{ route('setInterval') }}" method="post">
    @csrf
    <div class="row row-interval">
        <div class="col-md-12 d-flex justify-content-center align-items-center mt-2">
            <span class="title-interval">Notificar a falta de conexão a cada:</span> 
        </div>
        <div class="col-md-12 d-flex justify-content-center align-items-center mb-5">
            <span class="title-interval">{{$interval}}</span> 
        </div>
        <div class="col-md-4 offset-md-4 d-flex justify-content-center align-items-center col-title">
            <input class="form-control" type="time" min="00:00:15" step="1" name="time" id="" required>
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

@if (Session::has('error'))
    <div class="row d-flex justify-content-center mt-5">
        <div class="alert alert-danger alert-dismissible fade show w-50" role="alert">
            <strong>{{ Session::get('error') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@endsection

@section('content-js')
@endsection