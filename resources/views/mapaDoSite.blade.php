@extends('layouts.siteLayout')
@section('titulo','RETACE - Mapa do site')
@section('conteudo')
<div class="container card my-5">
	<div class="row">
        <div class="col-12">
            <div class="row">
                <h2 class="display-3 pl-4 h1">Mapa do Site</h2>
            </div>
        </div>
		<div id="conteudo" class="col-12 pt-5 pl-5" >
			<ul id="mapa-do-site">
                <li><a class="link-primary" href="{{url('/')}}">RETACE</a></li>
                <ul>
                    <li><a class="link-primary" href="{{url('/sobre')}}">Sobre</a></li>
                    <li><a class="link-primary" href="{{url('/aprender')}}">Aprender</a></li>
                    <li><a class="link-primary" href="{{url('/cadastrarTA')}}">Contribuir</a></li>
                    <li><a class="link-primary" href="{{url('/#caixa-de-busca')}}">Procurar recursos</a></li>
                </ul>
            </ul>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	$(document).ready(function() {

	});
</script>
@endsection