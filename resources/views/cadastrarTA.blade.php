@extends('layouts.siteLayout')
@section('titulo','RETACE Cadastrar Tecnologia Assistiva')
@section('conteudo')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-light">
                <div class="card-header">
                    <h1>
                        {{ __('Cadastrar Tecnologia Assistiva') }}
                    </h1>
                </div>
                <div class="card-body">
                    <form id="formCadastroRecursoTA" method="POST" action="{{ route('salvaTA') }}" enctype="multipart/form-data">
                        @csrf
                        <h3>Informações básicas</h3>
                        <div class="form-group required row mt-3" role="group" aria-labelledby="titulo">
                            <label for="titulo" class="col-md-4 col-form-label text-md-right">{{ __('Título') }}</label>
                            <div class="col-md-8">
                                <input id="titulo" type="text" class="form-control" name="titulo" value="{{ old('titulo') }}" autofocus>
                                <span class="invalid-feedback bold" role="alert" hidden></span>
                            </div>
                        </div>

                        <div class="form-group required row" role="group" aria-labelledby="descricao">
                            <label for="descricao" class="col-md-4 col-form-label text-md-right">{{ __('Breve descrição') }}</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="descricao" name="descricao" maxlength="1020">{{ old('descricao') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group required row" role="group" aria-labelledby="informaSeProdutoComercial">
                            <label id="informaSeProdutoComercial" class="col-md-4 col-form-label text-md-right">É um produto comercial?</label> 
                            <div id="produtoComercial" class="form-inline col-md-8">
                                <div class="form-check-inline col-md-4 ">
                                    <input class="form-check-input" type="radio" id="comercial" name="produtoComercial" value="true">
                                    <label for="produtoComercial" class="form-check-label">{{ __('Sim') }}</label>
                                </div>
                                <div class="form-check-inline col-md-4 ">                            
                                    <input class="form-check-input" type="radio" id="naoComercial" name="produtoComercial" value="false">
                                    <label for="produtoNaoComercial" class="form-check-label">{{ __('Não') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group required row" role="group" aria-labelledby="siteFabricante">
                            <label for="siteFabricante" class="col-md-4 col-form-label text-md-right">{{ __('Site do fabricante') }}</label>
                            <div class="col-md-8">
                                <input id="siteFabricante" type="text" class="form-control" name="siteFabricante" value="{{ old('siteFabricante') }}">
                            </div>
                        </div>

                        <div id="divLicenca" class="form-group required row d-none" role="group" aria-labelledby="licenca">
                            <label for="licenca" class="col-md-4 col-form-label text-md-right">{{ __('Licença') }}</label>
                            <div class="col-md-8">
                                <input id="licenca" type="text" class="form-control" name="licenca" value="{{ old('licenca') }}">
                            </div>
                        </div>

                        <div class="form-group required row" role="group" aria-labelledby="tags">
                            <label for="tags" class="col-md-4 col-form-label text-md-right">{{ __('Tags') }}</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="tags" id="tags"/>
                            </div>
                        </div>
                        <hr>
                        <h3 class="obrigatorio mt-4">Fotos</h3>
                        <p>Carregue pelo menos uma foto sobre a tecnologia assistiva no formato png, jpg ou  jpeg</p>
                        <div id="divFotos" class="form-group required row" role="group" aria-labelledby="fotos do recurso">
                            <div class="col-md-12">
                                <input id="fotos" name="fotos[]" accept="image/*" type="file" class="file" data-browse-on-zone-click="true"  multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Faça o upload de ao menos uma foto do recurso" data-allowed-file-extensions='["jpg", "jpeg", "png"]'>
                            </div>
                        </div>
                        <hr>
                        <h3 class="mt-4">Vídeos relacionados</h3>
                        <p> Informe o endereço (url) de vídeos sobre a tecnologia assistiva</p>
                        <div id="divVideos" class="form-group row" role="group" aria-labelledby="videos">
                            <label for="urlVideo" class="col-md-4 col-form-label text-md-right">{{ __('Adicionar vídeo') }}</label>
                            <div class="col-md-8 form-inline">
                                <input id="urlVideo" type="url"  class="w-75 form-control @error('videos[]') is-invalid @enderror" name="video" value="{{ old('video') }}">
                                <button id="btnAdicionarVideo" type="button" class="w-25 btn btn-primary"><i class="fa fa-plus-square fa-1" aria-label="Adicionar"></i></button>
                                @error('videos[]')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="offset-md-1 col-md-10 mt-4">
                                <label for="videos">{{__('Vídeos a serem cadastrados para este recurso:')}}</label>
                                <ul id="videos" class="list-group list-group-flush text-center">
                                    <li id="avisoListaVazia" class="list-group-item">Não serão adicionados vídeos</li>
                                </ul>
                            </div>                        
                        </div>
                        <hr>
                        <h3 class="mt-4">Arquivos</h3>
                        <p> Informe, se houver, endereços (url) para acessar arquivos relacionados ao recurso a ser cadastrado </p>
                        <div id="divArquivos" class="form-group row" role="group" aria-labelledby="arquivos associados">
                            <label for="urlArquivo" class="col-md-4 col-form-label text-md-right">{{ __('Adicionar arquivo') }}</label>
                            <div class="col-md-8 form-inline">
                                <input id="urlArquivo" type="url"  class="w-75 form-control @error('arquivos[]') is-invalid @enderror" name="arquivo" value="{{ old('arquivo') }}">
                                <button id="btnAdicionarArquivo" type="button" class="w-25 btn btn-primary"><i class="fa fa-plus-square fa-1" aria-label="Adicionar"></i></button>
                                @error('arquivos[]')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="offset-md-1 col-md-10 mt-4">
                                <label for="arquivos">{{__('Arquivos a serem cadastrados para este recurso:')}}</label>
                                <ul id="arquivos" class="list-group list-group-flush text-center">
                                    <li id="avisoListaVazia" class="list-group-item">Não serão adicionados arquivos</li>
                                </ul>                            
                            </div>                                          
                        </div>
                        <hr>
                        <h3 class="mt-4">Manuais</h3>
                        <p> Informe, se houver, endereços (url) para acessar manuais relacionados ao recurso a ser cadastrado </p>
                        <div id="divManuais" class="form-group row" role="group" aria-labelledby="manuais associados">
                            <label for="urlManual" class="col-md-4 col-form-label text-md-right">{{ __('Adicionar manual') }}</label>
                            <div class="col-md-8 form-inline">
                                <input id="urlManual" type="url"  class="w-75 form-control @error('manuais[]') is-invalid @enderror" name="manual" value="{{ old('manual') }}">
                                <button id="btnAdicionarManual" type="button" class="w-25 btn btn-primary"><i class="fa fa-plus-square fa-1" aria-label="Adicionar"></i></button>
                                @error('manuais[]')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="offset-md-1 col-md-10 mt-4">
                                <label for="manuais">{{__('Manuais a serem cadastrados para este recurso:')}}</label>
                                <ul id="manuais" class="list-group list-group-flush text-center">
                                    <li id="avisoListaVazia" class="list-group-item">Não serão adicionados manuais</li>
                                </ul>
                            </div> 
                        </div>
                        <hr>
                        <div class="form-group row mb-5 mt-4" role="group">
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
    var form = $('#formCadastroRecursoTA');

    $("#fotos").fileinput({
        theme: "explorer-fa",
        language: "pt-BR",
        uploadAsync: true,
        previewFileType: "image",
        browseClass: "btn btn-success",
        browseIcon: "<i class='fa fa-file-image-o' aria-hidden='true'></i>",
        removeClass: "btn btn-danger",
        removeIcon: "<i class='fa fa-trash' aria-hidden='true'></i>",
        removeFromPreviewOnError: true,
        fileActionSettings: {
            showUpload: false,
            showZoom: false,
        },
        overwriteInitial: true,
        uploadExtraData:{ _token: '{{ csrf_token()}}'},
        required: true          
    }); 

        function isUrlValid(url) {
            return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
        }

        $(document).ready(function () {
            var contadorUrls = 0;

            form.submit(function(e) {
                var formData = new FormData(form[0]);

                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: form.attr('action'),
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false, 
                    data: formData,
                    beforeSend: function(xhr)
                    {
                        xhr.setRequestHeader('X-CSRFToken', '{{ csrf_token() }}');
                    },
                    success: function(respostaServidor)
                    {
                        console.log("Sucesso!!\n"+console.log(JSON.stringify(respostaServidor)));
                    },
                    error: function(respostaServidor)
                    {
                        console.log("Erro!!\n "+respostaServidor);
                        $('.invalid-feedback').remove();
                        var erros = JSON.parse(respostaServidor.responseText);
                        if(erros){
                            $.map(erros, function(val, key) {
                            //testa se é um campo simples
                            if(key.lastIndexOf(".")==-1){
                                $('#'+key).after('<span class="invalid-feedback font-weight-bold d-block" role="alert">'+val+'</span>');
                            }else{//se for um campo que pertence a um array
                                var nomeArray = key.split('.');
                                $('[name^="'+nomeArray[0]+'"][name$="['+nomeArray[1]+']['+nomeArray[2]+']"]').after('<span class="invalid-feedback font-weight-bold d-block" role="alert">'+val+'</span>');
                            }
                        });
                        }
                    }
                });
            });

            /**Mostra o input licença quando o for produto comercial**/
            $('input[type=radio][name=produtoComercial]').change(function () {
                if($(this).val() === 'true') {
                    $('#divLicenca').removeClass('d-none');
                }
                else {
                    $('#divLicenca').addClass('d-none');
                }
            });

            var btnAdicionarVideo = $('#btnAdicionarVideo');
            var inputUrlVideo = $('#urlVideo');
            /**Adiciona a url do input video para a lista de urls**/
            btnAdicionarVideo.click(function(){

                inputUrlVideo.removeClass('is-invalid');
                inputUrlVideo.closest('div').find('span').remove();

                if(inputUrlVideo.val().length!='0'){
                    if(isUrlValid(inputUrlVideo.val())){
                //Remove o aviso de lista vazia quando adicionar o primeiro item;
                if ($('#videos').find('#avisoListaVazia').length) {
                    $('#videos').find('#avisoListaVazia').remove();
                }

                $("#videos").append(
                    '<li class="list-group-item">'+
                    '<div class="card">'+
                    '<div class="card-body"'+
                    '<h5>'+
                    '<i class="fa fa-star" aria-hidden="true"></i>'+
                    '<a href="'+inputUrlVideo.val()+'" class="mx-4">'+inputUrlVideo.val()+'</a>'+
                    '<i class="fa fa-trash" aria-hidden="true"></i>'+
                    '<input name="videos['+contadorUrls+'][url]" class="form-control" type="hidden" value="'+inputUrlVideo.val()+'"/>'+
                    '<input name="videos['+contadorUrls+'][destaque]" class="form-control" type="hidden" value="false"/>'+
                    '</h5>'+
                    '</div>'+
                    '</div>'+
                    '</li>');
                contadorUrls++;
            }else{
                inputUrlVideo.addClass("is-invalid");
                inputUrlVideo.closest('div').append(
                    '<span class="invalid-feedback" role="alert">'+
                    '<strong>Informe uma URL válida</strong>'+
                    '</span>');
            }
        }else{
            inputUrlVideo.addClass("is-invalid");
            inputUrlVideo.closest('div').append(
                '<span class="invalid-feedback" role="alert">'+
                '<strong>Informe uma URL antes de associar um vídeo ao recurso </strong>'+
                '</span>');
        }
    });

            /**Remove a url do video ao clicar na lixeira**/
            $('#divVideos').on('click', '.fa-trash', function (evento) {

                evento.preventDefault();
                $(this).closest('li').remove();

                if ($('#videos li').length === 0) {
                    $("#videos").append(
                        '<li id="avisoListaVazia" class="list-group-item">Não serão adicionados vídeos</li>');
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

            var btnAdicionarArquivo = $('#btnAdicionarArquivo');
            var inputUrlArquivo = $('#urlArquivo'); 
            /**Adiciona a url do input arquivo para a lista de urls**/
            btnAdicionarArquivo.click(function(){

                inputUrlArquivo.removeClass('is-invalid');
                inputUrlArquivo.closest('div').find('span').remove();

                if(inputUrlArquivo.val().length!='0'){ 
                    if(isUrlValid(inputUrlArquivo.val())){
                //Remove o aviso de lista vazia quando adicionar o primeiro item;
                if($('#arquivos').find('#avisoListaVazia').length) {
                    $('#arquivos').find('#avisoListaVazia').remove();
                }  

                $("#arquivos").append(
                    '<li class="list-group-item">'+
                    '<div class="card">'+
                    '<div class="card-body">'+
                    '<h5>'+
                    '<a class="col-md-10" href="'+inputUrlArquivo.val()+'" class="mx-4">'+inputUrlArquivo.val()+'</a>'+
                    '<i class="fa fa-trash col-md-2"></i></h5>'+
                    '</h5>'+
                    '<input name="arquivos['+contadorUrls+'][url]" class="form-control mt-2" type="hidden" value="'+inputUrlArquivo.val()+'"/>'+
                    '<input name="arquivos['+contadorUrls+'][nome]" class="form-control mt-2" type="text" placeholder="Nome do arquivo"/>'+
                    '<input name="arquivos['+contadorUrls+'][formato]" class="form-control mt-2" type="text" placeholder="Formato/extensão do arquivo"/>'+             
                    '<input name="arquivos['+contadorUrls+'][tamanho]" class="form-control mt-2" type="text" placeholder="Tamanho do arquivo (em Megabytes)"/>'+    
                    '</div>'+
                    '</div>'+
                    '</li>');
                contadorUrls++;
            }else{
                inputUrlArquivo.addClass("is-invalid");
                inputUrlArquivo.closest('div').append(
                    '<span class="invalid-feedback" role="alert">'+
                    '<strong>Informe uma URL válida</strong>'+
                    '</span>');
            }
        }else{
            inputUrlArquivo.addClass("is-invalid");
            inputUrlArquivo.closest('div').append(
                '<span class="invalid-feedback" role="alert">'+
                '<strong>Informe uma URL antes de associar um arquivo ao recurso </strong>'+
                '</span>');
        }
    });

            /**Remove da lista a url do arquivo ao clicar na lixeira**/
            $('#divArquivos').on('click', '.fa-trash', function (evento) {

                evento.preventDefault();
                $(this).closest('li').remove();

                if ($('#arquivos li').length === 0) {
                    $("#arquivos").append(
                        '<li id="avisoListaVazia" class="list-group-item">Não serão adicionados vídeos </li>');
                }
            });

            var btnAdicionarManual = $('#btnAdicionarManual');
            var inputUrlManual = $('#urlManual'); 
            /**Adiciona a url do input manual para a lista de urls**/
            btnAdicionarManual.click(function(){

                inputUrlManual.removeClass('is-invalid');
                inputUrlManual.closest('div').find('span').remove();

                if(inputUrlManual.val().length!='0'){
                    if(isUrlValid(inputUrlManual.val())){

                //Remove o aviso de lista vazia quando adicionar o primeiro item;
                if($('#manuais').find('#avisoListaVazia').length) {
                    $('#manuais').find('#avisoListaVazia').remove();
                }

                $("#manuais").append(
                    '<li class="list-group-item">'+
                    '<div class="card">'+
                    '<div class="card-body">'+
                    '<h5>'+
                    '<a class="col-md-10" href="'+inputUrlManual.val()+'" class="mx-4">'+inputUrlManual.val()+'</a>'+
                    '<i class="fa fa-trash col-md-2"></i>'+
                    '</h5>'+
                    '<input name="manuais['+contadorUrls+'][url]" class="form-control mt-2" type="hidden" value="'+inputUrlManual.val()+'"/>'+
                    '<input name="manuais['+contadorUrls+'][nome]" class="form-control mt-2" type="text" placeholder="Nome do manual"/>'+
                    '<input name="manuais['+contadorUrls+'][formato]" class="form-control mt-2" type="text" placeholder="Formato/extensão do manual"/>'+
                    '<input name="manuais['+contadorUrls+'][tamanho]" class="form-control mt-2" type="text" placeholder="Tamanho do manual (em Megabytes)"/>'+
                    '</div>'+
                    '</div>'+
                    '</li>');
                contadorUrls++;
            }else{
                inputUrlManual.addClass("is-invalid");
                inputUrlManual.closest('div').append(
                    '<span class="invalid-feedback" role="alert">'+
                    '<strong>Informe uma URL válida</strong>'+
                    '</span>');
            }

        }else{
            inputUrlManual.addClass("is-invalid");
            inputUrlManual.closest('div').append(
                '<span class="invalid-feedback" role="alert">'+
                '<strong>Informe uma URL antes de associar um manual ao recurso</strong>'+
                '</span>');
        }
    });

            /**Remove da lista a url do manual ao clicar na lixeira**/
            $('#divManuais').on('click', '.fa-trash', function (evento) {

                evento.preventDefault();
                $(this).closest('li').remove();

                if ($('#manuais li').length === 0) {
                    $("#manuais").append(
                        '<li id="avisoListaVazia" class="list-group-item">Não serão adicionados manuais </li>');
                }
            });

            $('input[name="tags"]').amsifySuggestags({
                showAllSuggestions: true,
                selectOnHover: true,
                keepLastOnHoverTag: false,
                printValues: false,
                suggestions: @json($tags),
                defaultTagClass: 'tagChip',
                noSuggestionMsg: 'Tag não encontrada, tecle enter para criar uma nova',
            });

            $('input[class="amsify-suggestags-input"]').attr("placeholder","Digite aqui");

        });
    </script> 
    @endsection
