@extends('template.master')

@section('title', 'Home')

@section('content-css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}"> 
@endsection

@section('content')
<form id="form" action="{{ route('verifyConnection') }}" method="post" onsubmit="return false">
    @csrf
</form>
<div class="row">
    @if ($status == 1)
        <div class="col-md-12 d-flex justify-content-center align-items-center mt-5">
            <i class="bi bi-cloud cloud-icon"></i>
        </div>
        <div class="col-md-12 d-flex justify-content-center align-items-center col-title">
            <span class="title-cloud">Conectado</span> 
        </div>
    @else
        <div class="col-md-12 d-flex justify-content-center align-items-center mt-5">
            <i class="bi bi-cloud-slash cloud-icon"></i>
        </div>
        <div class="col-md-12 d-flex justify-content-center align-items-center col-title">
            <span class="title-cloud">Desconectado</span> 
        </div>
    @endif
    
</div>
@endsection

@section('content-js')
<script>

    function verifyConnection() {

            setInterval(function () {
                document.getElementById("form").submit();
            }, 5000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            verifyConnection();
        });
</script>
@endsection