@php use App\Models\Producto; @endphp
{{-- Heredamos de nuestra plantilla --}}
@extends('main')

{{-- Ponemos el título --}}
@section('title', 'Detalles Producto')

{{-- Agregamos el contenido de la página --}}
@section('content')

    {{-- Agregamos el contenido de la página --}}

    <h1>Detalles del Producto</h1>
    <dl class="row">
        <dt class="col-sm-2">ID:</dt>
        <dd class="col-sm-10">{{ $producto->id }}</dd>
        <dt class="col-sm-2">Marca:</dt>
        <dd class="col-sm-10">{{ $producto->marca }}</dd>
        <dt class="col-sm-2">Modelo:</dt>
        <dd class="col-sm-10">{{ $producto->modelo }}</dd>
        <dt class="col-sm-2">Descripción:</dt>
        <dd class="col-sm-10">{{ $producto->descripcion }}</dd>
        <dt class="col-sm-2">Precio:</dt>
        <dd class="col-sm-10">{{ $producto->precio }}</dd>
        <dt class="col-sm-2">Imagen:</dt>
        <dd class="col-sm-10">
            @if($producto->imagen != Producto::$IMAGE_DEFAULT)
                <img alt="Imagen del producto" class="img-fluid" src="{{ asset('storage/' . $producto->imagen) }}">
            @else
                <img alt="Imagen por defecto" class="img-fluid" src="{{ Producto::$IMAGE_DEFAULT }}">
            @endif
        </dd>
        <dt class="col-sm-2">Stock:</dt>
        <dd class="col-sm-10">{{ $producto->stock }}</dd>
        <dt class="col-sm-2">Categoría:</dt>
        <dd class="col-sm-10">{{ $producto->categoria->nombre }}</dd>
    </dl>


    <a class="btn btn-primary" href="{{ route('productos.index') }}">Volver</a>

@endsection
