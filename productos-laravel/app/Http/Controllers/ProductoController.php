<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Exception;
use Illuminate\Http\Request;


class ProductoController extends Controller
{
    public function index(Request $request)
    {
        // Añadiendole el scope
        $productos = Producto::search($request->search)->orderBy('id', 'asc')->paginate(4);
        // Devolvemos la vista con los productos
        return view('productos.index')->with('productos', $productos);
    }

    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'marca' => 'min:4|max:120|required',
            'modelo' => 'min:4|max:120|required',
            'descripcion' => 'min:1|max:200|required',
            'precio' => 'required|regex:/^\d{1,13}(\.\d{1,2})?$/',
            'stock' => 'required|integer',
            'categoria' => 'required|in:COMIDA,DEPORTES,OCIO,BEBIDA,OTRO',
        ]);
        try {
            // Creamos el producto
            $producto = new Producto($request->all());
            // salvamos el producto
            $producto->save();
            // Devolvemos el producto creado
            flash('Producto ' . $producto->modelo . '  creado con éxito.')->success()->important();
            return $producto->toJson();
        } catch (Exception $e) {
            flash('Error al crear el Producto' . $e->getMessage())->error()->important();
            return redirect()->back(); // volvemos a la anterior
        }
    }

    public function create()
    {
        return "create";
    }

    public function show($id)
    {
        // Buscamos el producto por su id
        $producto = Producto::find($id);
        // Devolvemos el producto
        return view('productos.show')->with('producto', $producto);
    }

    public function edit($id)
    {
        // Buscamos el producto por su id
        $producto = Producto::find($id);
        // Devolvemos el producto
        return $producto->toJson();
    }

    public function editImage($id)
    {
        // Buscamos el producto por su id
        $producto = Producto::find($id);
        // Devolvemos el producto
        return $producto->toJson();
    }

    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'marca' => 'min:4|max:120|required',
            'modelo' => 'min:4|max:120|required',
            'descripcion' => 'min:1|max:200|required',
            'precio' => 'required|regex:/^\d{1,13}(\.\d{1,2})?$/',
            'stock' => 'required|integer',
            'categoria' => 'required|in:COMIDA,DEPORTES,OCIO,BEBIDA,OTRO',
        ]);
        try {
            // Buscamos el producto por su id
            $producto = Producto::find($id);
            // Actualizamos el producto
            $producto->update($request->all());
            /*$producto->marca = $request->marca;
            $producto->modelo = $request->modelo;
            $producto->descripcion = $request->descripcion;
            $producto->precio = $request->precio;
            $producto->stock = $request->stock;
            $producto->categoria = $request->categoria;*/

            // salvamos el producto
            $producto->save();
            // Devolvemos el producto actualizado
            flash('Producto ' . $producto->modelo . '  actualizado con éxito.')->warning()->important();
            return $producto->toJson();
        } catch (Exception $e) {
            flash('Error al actualizar el Producto' . $e->getMessage())->error()->important();
            return redirect()->back(); // volvemos a la anterior
        }
    }

    public function updateImage(Request $request, $id)
    {
        return "updateImage";
    }


    public function destroy($id)
    {
        try {
            // Buscamos el producto por su id
            $producto = Producto::find($id);
            // Actualizamos el producto
            $producto->isDeleted = true;
            // salvamos el producto
            $producto->delete();
            // Devolvemos el producto actualizado
            flash('Producto ' . $producto->modelo . '  eliminado con éxito.')->error()->important();
            return $producto->toJson();
        } catch (Exception $e) {
            flash('Error al eliminar el Producto' . $e->getMessage())->error()->important();
            return redirect()->back(); // volvemos a la anterior
        }
    }
}
