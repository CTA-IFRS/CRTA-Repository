@extends('adminlte::page')

@section('title', 'Painel do Administrador')

@section('content_header')
<h1 class="display-3">Painel do Administrador</h1>
@stop

@section('content')
<div class="d-flex flex-column h-100">
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <div class="row">
                <h2 class="display-4">Aprovação de Recursos de TA e Tags</h2>
            </div>
            <div class="row">
                <p class="lead">Verifique se há recursos aguardando aprovação</p> 
            </div>
        </div>
    </div>
    <div id="painel-fast-access" class="container-fluid flex-grow-1">
        <div class="row h-100 text-center">
            <div class="card col-sm-6 flex-grow-1 pt-4">
                <a href="{{route('administrarRecursosTA')}}">
                    <h3 class="display-5 pb-4">
                        <span class="sr-only">Acessar</span> Recursos de Tecnologia Assistiva
                    </h3>
                    <i class="fa fa-puzzle-piece fa-4 fa-10x" aria-hidden="true"></i>
                    <h4>
                        <span class="badge badge-warning py-3">{{__($qtdRecursosNaoAprovados)}} </span>
                        novos recursos aguardam aprovação
                    </h4>
                </a>
            </div>
            <div class="card col-sm-6 flex-grow-1 pt-4">
                <a href="{{route('administrarTags')}}">
                    <h3 class="display-5 pb-4">
                        <span class="sr-only">Acessar</span> Tags
                    </h3>
                    <i class="fa fa-tags fa-4 fa-10x" aria-hidden="true"></i>
                    <h4>
                        <span class="badge badge-warning py-3">{{__($qtdTagsNaoAprovadas)}} </span>
                        novas tags aguardam aprovação
                    </h4>
                </a>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link href="{{ asset('css/personalizacoes-admin.css') }}" rel="stylesheet">
@stop

@section('js')
<script type="text/javascript">
   $(document).ready(function () {
    $('.content-wrapper').addClass('d-flex');
    $('.content-wrapper').addClass('flex-column');
    $('.content').addClass('flex-grow-1');

    $(window).on('resize', function(){
        var alturaConteudo = $(this).height() - $('.navbar').outerHeight() - $('.content-header').outerHeight();
        $('.content > .container-fluid').height(alturaConteudo);
    }).trigger('resize');
});
</script>
@stop
