@extends('layouts.siteLayout')

@section('titulo','RETACE teste session')

@section('conteudo')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Painel do Usuário') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Você está logado!') }}
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
