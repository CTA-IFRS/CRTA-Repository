@extends('errors::illustrated-layout')

@section('code', '404 😭')

@section('title', __('Página não encontrada'))

@section('image')

<div style="background-image: url('/images/404-bg.jpg');" class="absolute pin bg-no-repeat md:bg-left lg:bg-center">
</div>

@endsection

@section('message', __('Desculpe, a página que busca não foi encontrada.'))