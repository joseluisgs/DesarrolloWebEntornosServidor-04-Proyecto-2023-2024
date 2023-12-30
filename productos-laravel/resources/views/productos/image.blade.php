@php use App\Models\Producto; @endphp
{{-- Heredamos de nuestra plantilla --}}
@extends('main')

{{-- Ponemos el título --}}
@section('title', 'Editar Imagen de Producto')

{{-- Agregamos el contenido de la página --}}
@section('content')
    <h1>Editar Imagen de Producto</h1>

    {{-- Codigos de validación de los errores, ver request validate del controlador --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br/>
    @endif

    <dl class="row">
        <dt class="col-sm-2">ID:</dt>
        <dd class="col-sm-10">{{$producto->id}}</dd>
        <dt class="col-sm-2">Marca:</dt>
        <dd class="col-sm-10">{{$producto->marca}}</dd>
        <dt class="col-sm-2">Modelo:</dt>
        <dd class="col-sm-10">{{$producto->modelo}}</dd>
        <dt class="col-sm-2">Imagen:</dt>
        <dd class="col-sm-10">
            @if($producto->imagen != Producto::$IMAGE_DEFAULT)
                <img alt="Imagen del producto" class="img-fluid" src="{{ asset('storage/' . $producto->imagen) }}">
            @else
                <img alt="Imagen por defecto" class="img-fluid" src="{{ Producto::$IMAGE_DEFAULT }}">
            @endif
        </dd>
    </dl>

    <form action="{{ route("productos.updateImage", $producto->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input accept="image/*" class="form-control-file" id="imagen" name="imagen" required type="file">
            <small class="text-danger"></small>
        </div>

        <button class="btn btn-primary" type="submit">Actualizar</button>
        <a class="btn btn-secondary mx-2" href="{{ route('productos.index') }}">Volver</a>
    </form>

@endsection
