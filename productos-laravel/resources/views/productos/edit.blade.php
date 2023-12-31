@php use App\Models\Producto; @endphp
{{-- Heredamos de nuestra plantilla --}}
@extends('main')

{{-- Ponemos el título --}}
@section('title', 'Editar Producto')

{{-- Agregamos el contenido de la página --}}
@section('content')
    <h1>Editar Producto</h1>

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

    <form action="{{ route("productos.update", $producto->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="marca">Marca:</label>
            <input class="form-control" id="marca" name="marca" type="text" required value="{{$producto->marca}}">
        </div>
        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input class="form-control" id="modelo" name="modelo" type="text" required value="{{$producto->modelo}}">
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required>{{$producto->descripcion}}
            </textarea>
        </div>
        <div class="form-group">
            <label for="precio">Precio:</label>
            <input class="form-control" id="precio" min="0.0" name="precio" step="0.01" type="number" required
                   value="{{$producto->precio}}">
        </div>
        <div class="form-group">
            <label for="stock">Stock:</label>
            <input class="form-control" id="stock" min="0" name="stock" type="number" required
                   value="{{$producto->stock}}">
        </div>
        <div class="form-group">
            <label for="categoria">Categoría:</label>
            <select class="form-control" id="categoria" name="categoria" required>
                <option>Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                    <option @if($producto->categoria->id == $categoria->id) selected
                            @endif value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary" type="submit">Actualizar</button>
        <a class="btn btn-secondary mx-2" href="{{ route('productos.index') }}">Volver</a>
    </form>

@endsection
