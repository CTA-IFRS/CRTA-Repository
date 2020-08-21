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

                        <div id="divLicenca" class="form-group required row d-none" role="group" aria-labelledby="licenca">
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

                        <div class="form-group required row" role="group" aria-labelledby="tags">
                            <label for="tags" class="col-md-4 col-form-label text-md-right">{{ __('Tags') }}</label>
                            <div class="col-md-8">
                                <div class="custom-control custom-checkbox">
                                     @foreach($tags as $tag)
                                        <div class="form-check-inline col-md-4 ">                            
                                            <input name="tags[]" title="$tag->descricao" type="checkbox" class="custom-control-input @error('tags[]') is-invalid @enderror" id="{{$tag->id}}" value="{{$tag->id}}">
                                            <label class="custom-control-label" for="{{$tag->id}}">{{$tag->nome}}</label>
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

                        <div id="divVideos" class="form-group row" role="group" aria-labelledby="videos">
                            <label for="urlVideo" class="col-md-4 col-form-label text-md-right">{{ __('URL Vídeo') }}</label>
                            <div class="col-md-8 form-inline">
                                <input id="urlVideo" type="url"  class="w-75 form-control @error('videos[]') is-invalid @enderror" name="video" value="{{ old('video') }}">
                                <button id="btnAdicionarVideo" type="button" class="w-25 btn btn-primary">Adicionar</button>
                                @error('videos[]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="offset-md-4 col-md-8 mt-1">
                                <ul id="videos" class="list-group text-center">
                                </ul>
                            </div>                        
                        </div>
                        <div class="form-group row mb-0" role="group">
                            <div class="col-md-2 offset-md-10 ">
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
@section('scripts')
<script>
$(document).ready(function () {

    var contadorUrls = 0;
    /**Mostra o input licença quando o for produto comercial**/
    $('input[type=radio][name=produtoComercial]').change(function () {
        if($(this).val() === 'true') {
            $('#divLicenca').removeClass('d-none');
        }
        else {
            $('#divLicenca').addClass('d-none');
        }
    });

    function isUrlValid(url) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
    }

    /**Adiciona a url do input video para a lista de urls**/
    $('#btnAdicionarVideo').click(function(){

        if($('#urlVideo').val().length!='0'){
            if(isUrlValid($('#urlVideo').val())){
                $("#videos").append('<li class="list-group-item"><svg role="img" alt="destacar" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-star-fill cursor-pointer" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg><a href="'+$('#urlVideo').val()+'" class="mx-4">'+$('#urlVideo').val()+'</a><svg role="img" alt="excluir" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-trash cursor-pointer" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg><input name="videos['+contadorUrls+'][url]" class="form-control" type="hidden" value="'+$('#urlVideo').val()+'"/><input name="videos['+contadorUrls+'][destaque]" class="form-control" type="hidden" value="false"/></li>');
                    contadorUrls++;
            }
        }else{
            $('#urlVideo').addClass("is-invalid");
        }
    });

    /**Remove a url ao clicar na lixeira**/
    $(document).on('click', '.bi-trash', function (evento) {
        evento.preventDefault();
       $(this).closest('li').remove();
    });

    /**Remove a url ao clicar na lixeira**/
    $(document).on('click', '.bi-star-fill', function (evento) {
        evento.preventDefault();

        //Itera sobre os destaques da lista procurando desfazer a antiga indicação, se houver
        $('[name^="videos"][name$="[destaque]"]').each(function(i,elemento){
            if(elemento.value==='true'){
                elemento.value ='false';
                $(elemento).closest('li').removeClass('destaque');
            }
        });

       $(this).closest('li').find('[name^="videos"][name$="[destaque]"]').val('true');
       $(this).closest('li').addClass('destaque');
    });
});
</script> 
@endsection
