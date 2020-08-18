@extends('layouts.siteLayout')
@section('titulo','RETACE Formulário de Cadastro do Usuário')
@section('conteudo')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cadastrar Tecnologia Assistiva') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('salvaTA') }}">
                        @csrf
                        <div class="form-group required row" role="group" aria-labelledby="titulo">
                            <label for="titulo" class="col-md-4 col-form-label text-md-right">{{ __('Título') }}</label>
                            <div class="col-md-8">
                                <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="{{ old('titulo') }}" autofocus>
                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group required row" role="group" aria-labelledby="descricao">
                            <label for="descricao" class="col-md-4 col-form-label text-md-right">{{ __('Breve descrição') }}</label>
                            <div class="col-md-8">
                                <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" maxlength="1020">{{ old('descricao') }}</textarea>
                                @error('descricao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group required row" role="group" aria-labelledby="informaSeProdutoComercial">
                            <label id="informaSeProdutoComercial" class="col-md-4 col-form-label text-md-right">É um produto comercial?</label> 
                            <div class="form-inline col-md-8 @error('produtoComercial') is-invalid @enderror">
                                <div class="form-check-inline col-md-4 ">
                                    <input class="form-check-input @error('produtoComercial') is-invalid @enderror" type="radio" id="produtoComercial" name="produtoComercial" value="true">
                                    <label for="produtoComercial" class="form-check-label">{{ __('Sim') }}</label>
                                </div>
                                <div class="form-check-inline col-md-4 ">                            
                                    <input class="form-check-input @error('produtoComercial') is-invalid @enderror" type="radio" id="produtoNaoComercial" name="produtoComercial" value="false">
                                    <label for="produtoNaoComercial" class="form-check-label">{{ __('Não') }}</label>
                                </div>
                            </div>
                            @error('produtoComercial')
                            <span class="invalid-feedback offset-md-4 col-md-8" role="alert">
                                 <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group required row" role="group" aria-labelledby="siteFabricante">
                            <label for="siteFabricante" class="col-md-4 col-form-label text-md-right">{{ __('Site do fabricante') }}</label>
                            <div class="col-md-8">
                                <input id="siteFabricante" type="text" class="form-control @error('siteFabricante') is-invalid @enderror" name="siteFabricante" value="{{ old('siteFabricante') }}">
                                @error('siteFabricante')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" role="group" aria-labelledby="licenca">
                            <label for="licenca" class="col-md-4 col-form-label text-md-right">{{ __('Licença') }}</label>
                            <div class="col-md-8">
                                <input id="licenca" type="text" class="form-control @error('licenca') is-invalid @enderror" name="licenca" value="{{ old('licenca') }}">
                                @error('licenca')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" role="group" aria-labelledby="">
                            <label for="tags" class="col-md-4 col-form-label text-md-right">{{ __('Tags') }}</label>
                            <div class="col-md-8">
                                <div class="custom-control custom-checkbox">
                                     @foreach($tags as $tag)
                                    <div class="form-check-inline col-md-4 ">                            
                                        <input name="tags[]" title="$tag->descricao" type="checkbox" class="custom-control-input @error('tags[]') is-invalid @enderror" id="{{$tag->id}}" value="{{$tag->id}}">
                                        <label class="custom-control-label" for="tags[]">{{$tag->nome}}</label>
                                    </div>
                                     @endforeach
                                </div>
                            </div>
                                @error('tags[]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group row mb-0" role="group">
                            <div class="col-md-6 offset-md-10 ">
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
