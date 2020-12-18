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
                <h1 class="display-4">Aprovação de Recursos de TA e Tags</h1>
            </div>
            <div class="row">
                <p class="lead">Verifique se há recursos aguardando aprovação</p> 
            </div>
        </div>
    </div>
    <div class="container-fluid flex-grow-1">
        <div class="row h-100 text-center">
            <div class="card col-sm-6 flex-grow-1 pt-4">
                <h2 class="display-5 pb-4">Recursos de Tecnologia Assistiva</h2>
                <i class="fa fa-puzzle-piece fa-4 fa-10x" aria-hidden="true"></i>
                <h4>
                    <span class="badge badge-warning py-3">{{__($qtdRecursosNaoAprovados)}} </span>
                    novos recursos aguardam aprovação
                </h4>
            </div>
            <div class="card col-sm-6 flex-grow-1 pt-4">
                <h2 class="display-5 pb-4">Tags</h2>
                <i class="fa fa-tags fa-4 fa-10x" aria-hidden="true"></i>
                <h4>
                    <span class="badge badge-warning py-3">{{__($qtdTagsNaoAprovadas)}} </span>
                    novas tags aguardam aprovação
                </h4>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
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
