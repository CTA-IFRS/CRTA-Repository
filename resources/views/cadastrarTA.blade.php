@extends('layouts.siteLayout')
@section('titulo','RETACE Cadastrar Tecnologia Assistiva')
@section('conteudo')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cadastrar Tecnologia Assistiva') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('salvaTA') }}" enctype="multipart/form-data">
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
                <p> Carregue, a partir do seu computador, arquivos relacionados à tecnologia assistiva no formato doc, docx, pdf, txt e XXXXXXX </p>
                <div id="divArquivos" class="form-group row" role="group" aria-labelledby="arquivos associados">
                    <div class="custom-file">
                        <label for="arquivos" class="offset-md-4 col-md-7 custom-file-label">{{__('Associar arquivos ao recurso')}}</label>
                        <input type="file" class="custom-file-input" id="arquivos" name="arquivos[]" multiple>
                    </div>
                    <div class="offset-md-4 col-md-8 mt-3">
                        <label for="listaArquivos">{{__('Arquivos a serem associados a este recurso:')}}</label>
                        <ul id="listaArquivos" class="list-group text-center">
                            <li id="avisoListaVazia" class="list-group-item">Não serão adicionados arquivos</li>
                        </ul>
                    </div> 
                </div>
                <hr>
                <h3>Manuais</h3>
                <p> Carregue, a partir do seu computador, manuais da tecnologia assistiva no formato doc, docx, pdf XXXXX</p>
                <div id="divManuais" class="form-group row" role="group" aria-labelledby="manuais associados">
                    <div class="custom-file">
                        <label for="manuais" class="offset-md-4 col-md-7 custom-file-label">{{__('Associar manuais ao recurso')}}</label>
                        <input type="file" accept="application/pdf" class="custom-file-input" id="manuais" name="manuais[]" multiple>
                    </div>
                    <div class="offset-md-4 col-md-8 mt-3">
                        <label for="listaManuais">{{__('Manuais a serem associados:')}}</label>
                        <ul id="listaManuais" class="list-group text-center">
                            <li id="avisoListaVazia" class="list-group-item">Não serão adicionados manuais</li>
                        </ul>
                    </div> 
                </div>
                <hr>
                <h3>Fotos</h3>
                <p>Carregue pelo menos uma foto sobre a tecnologia assistiva no formato png ou jpg</p>
                <div id="divFotos" class="form-group row" role="group" aria-labelledby="fotos do recurso">
                    <div class="custom-file">
                        <label for="fotos" class="offset-md-4 col-md-7 custom-file-label">{{__('Cadastrar fotos da tecnologia assistiva')}}</label>
                        <input type="file" class="custom-file-input" id="fotos" name="fotos[]" multiple>
                    </div>
                    <div class="offset-md-4 col-md-8 mt-3">
                        <label for="listaFotos">{{__('Fotos a serem cadastradas:')}}</label>
                        <ul id="listaFotos" class="list-group text-center">
                            <li id="avisoListaVazia" class="list-group-item">Cadastre ao menos uma foto</li>
                        </ul>
                    </div> 
                </div>
                <hr>
                <div class="form-group row mb-0 mt-4" role="group">
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

        /**Remove a url ao clicar na lixeira**/
        $(document).on('click', '.fa-trash', function (evento) {

            evento.preventDefault();
            $(this).closest('li').remove();

            if ($('#videos li').length === 0) {
                $("#videos").append('<li id="avisoListaVazia" class="list-group-item">Não foram adicionados vídeos</li>');
            }
        });

        /**Seleciona uma das urls como favorita**/
        $(document).on('click', '.fa-star', function (evento) {
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

        /** Lista os arquivos escolhidos no input file para fornecer feedback ao usuário**/
        $("input[id=arquivos]").on("change", function () {

            $('ul[id=listaArquivos]').empty();

            var arquivos = $("input[id=arquivos]").prop("files")
            var nomes = $.map(arquivos, function (val) { return val.name; });
            $.each(nomes, function (i, nome) {
                $("#listaArquivos").append('<li class="list-group-item"><i class="fa fa-file mr-2" aria-hidden="true"></i>'+nome+'</li>');
            });
            if( $('#listaArquivos li').length===0){
                $('#listaArquivos').append('<li id="avisoListaVazia" class="list-group-item">Não foram adicionados arquivos</li>');
            }
        });

        /** Lista os arquivos escolhidos no input file para fornecer feedback ao usuário**/
        $("input[id=manuais]").on("change", function () {

            $('ul[id=listaManuais]').empty();

            var manuais = $("input[id=manuais]").prop("files")
            var nomes = $.map(manuais, function (val) { return val.name; });
            $.each(nomes, function (i, nome) {
                $("#listaManuais").append('<li class="list-group-item"><i class="fa fa-file mr-2" aria-hidden="true"></i>'+nome+'</li>');
            });
            if( $('#listaManuais li').length===0){
                $('#listaManuais').append('<li id="avisoListaVazia" class="list-group-item">Não serão adicionados manuais</li>');
            }
        });
    });
</script> 
@endsection
