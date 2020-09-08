@extends('layouts.siteLayout')
@section('titulo','RETACE Cadastrar Tecnologia Assistiva')
@section('conteudo')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h1>{{ __('Cadastrar Tecnologia Assistiva') }}</h1></div>

                <div class="card-body">
                    <form id="formCadastroRecursoTA" method="POST" action="{{ route('salvaTA') }}" enctype="multipart/form-data">
                        @csrf
                        <h3>Informações básicas</h3>
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
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" name="tags" id="tags"/>
                            @error('tags')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <h3>Fotos</h3>
                    <p>Carregue pelo menos uma foto sobre a tecnologia assistiva no formato png ou jpg</p>
                    <div id="divFotos" class="form-group row" role="group" aria-labelledby="fotos do recurso">
                        <div class="col-md-12">
                            <input id="fotos" name="fotos[]" accept="image/*" type="file" class="file" data-browse-on-zone-click="true"  multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Faça o upload de ao menos uma foto do recurso" data-allowed-file-extensions='["jpg", "jpeg", "png"]'>
                        </div>
                    </div>
                    <hr>
                    <h3>Vídeos relacionados</h3>
                    <p> Informe o endereço (url) de vídeos sobre a tecnologia assistiva</p>
                    <div id="divVideos" class="form-group row" role="group" aria-labelledby="videos">
                        <label for="urlVideo" class="col-md-4 col-form-label text-md-right">{{ __('Adicionar vídeo') }}</label>
                        <div class="col-md-8 form-inline">
                            <input id="urlVideo" type="url"  class="w-75 form-control @error('videos[]') is-invalid @enderror" name="video" value="{{ old('video') }}">
                            <button id="btnAdicionarVideo" type="button" class="w-25 btn btn-primary">{{ __('Adicionar') }}</button>
                            @error('videos[]')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="offset-md-4 col-md-8 mt-3">
                            <label for="videos">{{__('Vídeos a serem cadastrados para este recurso:')}}</label>
                            <ul id="videos" class="list-group text-center">
                                <li id="avisoListaVazia" class="list-group-item">Não serão adicionados vídeos</li>
                            </ul>
                        </div>                        
                    </div>
                    <hr>
                    <h3>Arquivos</h3>
                    <p> Informe, se houver, endereços (url) para acessar arquivos relacionados ao recurso a ser cadastrado </p>
                    <div id="divArquivos" class="form-group row" role="group" aria-labelledby="arquivos associados">
                        <label for="urlArquivo" class="col-md-4 col-form-label text-md-right">{{ __('Adicionar arquivo') }}</label>
                        <div class="col-md-8 form-inline">
                            <input id="urlArquivo" type="url"  class="w-75 form-control @error('arquivos[]') is-invalid @enderror" name="arquivo" value="{{ old('arquivo') }}">
                            <button id="btnAdicionarArquivo" type="button" class="w-25 btn btn-primary">{{ __('Adicionar') }}</button>
                            @error('arquivos[]')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="offset-md-1 col-md-10 mt-3">
                            <label for="arquivos">{{__('Arquivos a serem cadastrados para este recurso:')}}</label>
                            <ul id="arquivos" class="list-group text-center">
                                <li id="avisoListaVazia" class="list-group-item">Não serão adicionados arquivos</li>
                            </ul>
                        </div>                                          
                    </div>
                    <hr>
                    <h3>Manuais</h3>
                    <p> Informe, se houver, endereços (url) para acessar manuais relacionados ao recurso a ser cadastrado </p>
                    <div id="divManuais" class="form-group row" role="group" aria-labelledby="manuais associados">
                        <label for="urlManual" class="col-md-4 col-form-label text-md-right">{{ __('Adicionar manual') }}</label>
                        <div class="col-md-8 form-inline">
                            <input id="urlManual" type="url"  class="w-75 form-control @error('manuais[]') is-invalid @enderror" name="manual" value="{{ old('manual') }}">
                            <button id="btnAdicionarManual" type="button" class="w-25 btn btn-primary">{{ __('Adicionar') }}</button>
                            @error('manuais[]')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="offset-md-1 col-md-10 mt-3">
                            <label for="manuais">{{__('Manuais a serem cadastrados para este recurso:')}}</label>
                            <ul id="manuais" class="list-group text-center">
                                <li id="avisoListaVazia" class="list-group-item">Não serão adicionados manuais</li>
                            </ul>
                        </div> 
                    </div>
                    <hr>
                    <div class="form-group row mb-0 mt-4" role="group">
                        <div class="col-md-2 offset-md-10 ">
                            <button id="btnEnviaForm" type="submit" class="btn btn-primary">
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

    $("#fotos").fileinput({
        theme: "explorer-fa",
        language: "pt-BR",
        previewFileType: "image",
        browseClass: "btn btn-success",
        browseIcon: "<i class='fa fa-file-image-o' aria-hidden='true'></i>",
        removeClass: "btn btn-danger",
        removeIcon: "<i class='fa fa-trash' aria-hidden='true'></i>",
        removeFromPreviewOnError: true,
        required: true          
    });

    function isUrlValid(url) {
        return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
    }

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

    /**Adiciona a url do input video para a lista de urls**/
    $('#btnAdicionarVideo').click(function(){
        //Remove o aviso de lista vazia quando adicionar o primeiro item;
        if ($('#videos').find('#avisoListaVazia').length) {
            $('#videos').find('#avisoListaVazia').remove();
        }

        if($('#urlVideo').val().length!='0'){
            if(isUrlValid($('#urlVideo').val())){
                $("#videos").append('<li class="list-group-item"><i class="fa fa-star" aria-hidden="true"></i><a href="'+$('#urlVideo').val()+'" class="mx-4">'+$('#urlVideo').val()+'</a><i class="fa fa-trash" aria-hidden="true"></i><input name="videos['+contadorUrls+'][url]" class="form-control" type="hidden" value="'+$('#urlVideo').val()+'"/><input name="videos['+contadorUrls+'][destaque]" class="form-control" type="hidden" value="false"/></li>');
                contadorUrls++;
            }
        }else{
            $('#urlVideo').addClass("is-invalid");
        }
    });

    /**Remove a url do video ao clicar na lixeira**/
    $('#divVideos').on('click', '.fa-trash', function (evento) {

        evento.preventDefault();
        $(this).closest('li').remove();

        if ($('#videos li').length === 0) {
            $("#videos").append('<li id="avisoListaVazia" class="list-group-item">Não foram adicionados vídeos</li>');
        }
    });

    /**Seleciona uma das urls como favorita**/
    $('#divVideos').on('click', '.fa-star', function (evento) {
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


    /**Adiciona a url do input arquivo para a lista de urls**/
    $('#btnAdicionarArquivo').click(function(){
        //Remove o aviso de lista vazia quando adicionar o primeiro item;
        if ($('#arquivos').find('#avisoListaVazia').length) {
            $('#arquivos').find('#avisoListaVazia').remove();
        }
        
        if($('#urlArquivo').val().length!='0'){
            if(isUrlValid($('#urlArquivo').val())){
                $("#arquivos").append('<li class="list-group-item"><div class="row"><a class="col-md-10" href="'+$('#urlArquivo').val()+'" class="mx-4">'+$('#urlArquivo').val()+'</a><i class="fa fa-trash col-md-2"></i><input name="arquivos['+contadorUrls+'][url]" class="form-control" type="hidden" value="'+$('#urlArquivo').val()+'"/></div><div class="row mt-2"><input name="arquivos['+contadorUrls+'][nome]" class="form-control" type="text" placeholder="Nome do arquivo"/></div><div class="row mt-2"><input name="arquivos['+contadorUrls+'][formato]" class="form-control" type="text" placeholder="Formato/extensão do arquivo"/></div><div class="row mt-2"><input name="arquivos['+contadorUrls+'][tamanho]" class="form-control" type="text" placeholder="Tamanho do arquivo (em Megabytes)"/></div></li>');
                contadorUrls++;
            }
        }else{
            $('#urlArquivo').addClass("is-invalid");
        }
    });

    /**Remove da lista a url do arquivo ao clicar na lixeira**/
    $('#divArquivos').on('click', '.fa-trash', function (evento) {

        evento.preventDefault();
        $(this).closest('li').remove();

        if ($('#arquivos li').length === 0) {
            $("#arquivos").append('<li id="avisoListaVazia" class="list-group-item">Não serão adicionados vídeos </li>');
        }
    });

    /**Adiciona a url do input manual para a lista de urls**/
    $('#btnAdicionarManual').click(function(){
        //Remove o aviso de lista vazia quando adicionar o primeiro item;
        if ($('#manuais').find('#avisoListaVazia').length) {
            $('#manuais').find('#avisoListaVazia').remove();
        }
        
        if($('#urlManual').val().length!='0'){
            if(isUrlValid($('#urlManual').val())){
                $("#manuais").append('<li class="list-group-item"><div class="row"><a class="col-md-10" href="'+$('#urlManual').val()+'" class="mx-4">'+$('#urlManual').val()+'</a><i class="fa fa-trash col-md-2"></i><input name="manuais['+contadorUrls+'][url]" class="form-control" type="hidden" value="'+$('#urlManual').val()+'"/></div><div class="row mt-2"><input name="manuais['+contadorUrls+'][nome]" class="form-control" type="text" placeholder="Nome do manual"/></div><div class="row mt-2"><input name="manuais['+contadorUrls+'][formato]" class="form-control" type="text" placeholder="Formato/extensão do manual"/></div><div class="row mt-2"><input name="manuais['+contadorUrls+'][tamanho]" class="form-control" type="text" placeholder="Tamanho do manual (em Megabytes)"/></div></li>');
                contadorUrls++;
            }
        }else{
         $('#urlManual').addClass("is-invalid");
     }
 });

    /**Remove da lista a url do manual ao clicar na lixeira**/
    $('#divManuais').on('click', '.fa-trash', function (evento) {

        evento.preventDefault();
        $(this).closest('li').remove();

        if ($('#manuais li').length === 0) {
            $("#manuais").append('<li id="avisoListaVazia" class="list-group-item">Não serão adicionados manuais </li>');
        }
    });

    $('input[name="tags"]').amsifySuggestags({
        suggestions: @json($tags),
        defaultTagClass: 'tagChip',
        noSuggestionMsg: 'Tag não encontrada, tecle enter para criar uma nova',
    });

    $('input[class="amsify-suggestags-input"]').attr("placeholder","Digite aqui");

});
</script> 
@endsection
