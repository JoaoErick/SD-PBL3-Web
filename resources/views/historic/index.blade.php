@extends('template.master')

@section('title', 'Histórico')

@section('content-css')
<link rel="stylesheet" href="{{ asset('css/historic.css') }}">
@endsection

@section('content')
    <form action="{{ route('refresh') }}" method="post" id="refresh_form" onsubmit="return false">
        @csrf
        <div class="row mt-3">
            <div class="col-12">
                <a class="mx-3 navbar-brand refresh-icon" onclick="document.getElementById('refresh_form').submit();">
                    <i class="bi bi-arrow-counterclockwise"></i> Atualizar
                </a>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-8 offset-2 d-flex justify-content-center align-items-center">
            <table class="table table-borderless mt-5">
                <thead>
                  <tr>
                    <th scope="col" class="table-font-size-custom">Data</th>
                    <th scope="col" class="table-font-size-custom">Horário</th>
                    <th scope="col" class="table-font-size-custom">Evento</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($historics as $historic)
                    <tr>
                        <th scope="col" class="table-font-size-custom">{{ \Carbon\Carbon::parse($historic->created_at)->format('d/m/Y') }}</th>
                        <th scope="col" class="table-font-size-custom">{{ $historic->schedule }}</th>
                        <th scope="col" class="table-font-size-custom">{{ $historic->event }}</th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection



@section('content-js')
    
@endsection