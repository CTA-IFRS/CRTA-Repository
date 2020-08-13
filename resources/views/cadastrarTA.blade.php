@extends('layouts.siteLayout')
@section('titulo','RETACE Formulário de Cadastro do Usuário')
@section('conteudo')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cadastrar Tecnologia Assistiva') }}</div>

                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="titulo" class="col-md-4 col-form-label text-md-right">{{ __('Título') }}</label>
                            <div class="col-md-6">
                                <!-- Ver como validar os campos usando  @error('nomeCampo') is-invalid @enderror -->
                                <input id="titulo" type="text" class="form-control" name="titulo" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descricao" class="col-md-4 col-form-label text-md-right">{{ __('Descrição') }}</label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="descricao" name="descricao" maxlength="1020"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-md-4 col-md-8">
                                <div class="form-check-inline col-md-4 ">
                                    <input class="form-check-input" type="radio" id="produtoComercial" name="produtoComercial" value="" checked>
                                    <label for="produtoComercial" class="form-check-label">{{ __('Produto comercial') }}</label>
                                </div>
                                <div class="form-check-inline col-md-4 ">                            
                                    <input class="form-check-input" type="radio" id="produtoNaoComercial" name="produtoNaoComercial" value="">
                                    <label for="produtoNaoComercial" class="form-check-label">{{ __('Produto não comercial') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="siteFabricante" class="col-md-4 col-form-label text-md-right">{{ __('Site do fabricante') }}</label>
                            <div class="col-md-6">
                                <input id="siteFabricante" type="text" class="form-control" name="siteFabricante">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="licenca" class="col-md-4 col-form-label text-md-right">{{ __('Licença') }}</label>
                            <div class="col-md-6">
                                <input id="licenca" type="text" class="form-control" name="licenca">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Cadastrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
