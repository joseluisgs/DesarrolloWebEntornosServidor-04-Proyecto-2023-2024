@php use App\Models\Producto; @endphp
{{-- Heredamos de nuestra plantilla --}}
@extends('main')

{{-- Ponemos el título --}}
@section('title', 'Productos CRUD')

{{-- Agregamos el contenido de la página --}}
@section('content')
    <h1>Listado de Productos</h1>

    {{-- Agregamos el contenido de la página --}}

    <form action="{{ route('productos.index') }}" class="mb-3" method="get">
        @csrf
        <div class="input-group">
            <input type="text" class="form-control" id="search" name="search" placeholder="Marca o Modelo">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </div>
    </form>

    {{-- Si hay registros --}}
    @if (count($productos) > 0)
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>

            {{-- Por cada producto --}}
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->marca }}</td>
                    <td>{{ $producto->modelo }}</td>
                    <td>{{ $producto->precio }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>
                        @if($producto->imagen != Producto::$IMAGE_DEFAULT)
                            <img alt="Imagen del producto" height="50" src="{{ asset('storage/' . $producto->imagen) }}"
                                 width="50">
                        @else
                            <img alt="Imagen por defecto" height="50" src="{{ Producto::$IMAGE_DEFAULT }}"
                                 width="50">
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ url('productos', ['id' => $producto->id]) }}">Detalles</a>
                        <a class="btn btn-secondary btn-sm" href="{{ url('edit', ['id' => $producto->id]) }}">Editar</a>
                        <a class="btn btn-info  btn-sm" href="{{ url('image', ['id' => $producto->id]) }}">Imagen</a>
                        <a class="btn btn-danger btn-sm" href="{{ url('delete', ['id' => $producto->id]) }}"
                           onclick="return confirm('¿Estás seguro de que deseas borrar este producto?')">Borrar</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{--Si no hay productos mostramos el mensaje--}}
    @else
        <p class='lead'><em>No se ha encontrado datos de productos.</em></p>
    @endif

    {{--El paginador sólo aparece cuando superemos los usuarios puestos en paginate()
       del controlador--}}
    <div class="pagination-container">
        {{ $productos->links('pagination::bootstrap-4') }}
    </div>

    <a class="btn btn-success" href={{ route('productos.create') }}>Nuevo Producto</a>

@endsection
