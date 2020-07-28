@extends('layouts.app')


@section('content')
    <h1>Cadastrar repositorio</h1>
    <form action="{{route('admin.stores.store')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}">

        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">

            @error('name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{old('description')}}">

            @error('description')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror

        </div>

        <div class="form-group">
            <label>Instituição</label>
            <input type="text" name="phone" class="form-control" value="{{old('phone')}}">

        </div>

        <div class="form-group">
            <label>Arquivo</label>
            <input type="text" name="mobile_phone" class="form-control" value="{{old('mobile_phone')}}">

        </div>

        <div class="form-group">
            <label>Fotos</label>
            <input type="file" name="logo" class="form-control">
        </div>


{{--        <div class="form-group">--}}
{{--            <label>Slug</label>--}}
{{--            <input type="text" name="slug" class="form-control" value="{{old('slug')}}">--}}

{{--        </div>--}}

        <div>
            <button type="submit" class="btn btn-lg btn-primary">Enviar</button>
        </div>
    </form>
@endsection

{{--<div class="form-group">--}}
{{--    <label>Nome da TA</label>--}}
{{--    <input type="text" name="name" class="form-control is-invalid" value="{{old('name')}}">>--}}

{{--    @error('name')--}}
{{--    <h6>Preenchimento obrigatório</h6>--}}
{{--    @enderror--}}
{{--</div>--}}
