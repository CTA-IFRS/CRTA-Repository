@extends('layouts.app')


@section('content')
    <h1>Editar repositorio</h1>
    <form action="{{route('admin.stores.update', ['store'=>$store->id])}}" method="post" enctype="multipart/form-data">
        @csrf
        @method("PUT")

        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" class="form-control" value="{{$store->name}}">
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <input type="text" name="description" class="form-control" value="{{$store->description}}">
        </div>

        <div class="form-group">
            <label>Instituição</label>
            <input type="text" name="phone" class="form-control" value="{{$store->phone}}">
        </div>

        <div class="form-group">
            <label>Arquivo</label>
            <input type="text" name="mobile_phone" class="form-control" value="{{$store->mobile_phone}}">
        </div>

        <div class="form-group">
            <p>
                <img src="{{asset('storage/' . $store->logo)}}" alt="">
            </p>
            <label>Fotos</label>
            <input type="file" name="logo" class="form-control">
        </div>

{{--        <div class="form-group">--}}
{{--            <label>Slug</label>--}}
{{--            <input type="text" name="slug" class="form-control" value="{{$store->slug}}">--}}
{{--        </div>--}}


        <div>
            <button type="submit" class="btn btn-lg btn-primary">Atualizar Loja</button>
        </div>
    </form>
@endsection
