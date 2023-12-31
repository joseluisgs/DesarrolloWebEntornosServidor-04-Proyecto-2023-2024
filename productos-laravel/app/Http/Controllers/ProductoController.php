<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductoController extends Controller
{
    public function index(Request $request)
    {
        // Añadiendole el scope
        $productos = Producto::search($request->search)->orderBy('id', 'asc')->paginate(4);
        // Devolvemos la vista con los productos
        return view('productos.index')->with('productos', $productos);
    }

    public function show($id)
    {
        // Buscamos el producto por su id
        $producto = Producto::find($id);
        // Devolvemos el producto
        return view('productos.show')->with('producto', $producto);
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create')->with('categorias', $categorias);
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
            'categoria' => 'required|exists:categorias,id', // Asegúrate de que la columna 'id' sea la correcta en value del formulario (autovalida que exista en la tabla categorias)
        ]);
        try {
            // Creamos el producto
            $producto = new Producto($request->all());
            // Asignamos la categoría
            $producto->categoria_id = $request->categoria;
            // salvamos el producto
            $producto->save();
            // Devolvemos el producto creado
            flash('Producto ' . $producto->modelo . '  creado con éxito.')->success()->important();
            return redirect()->route('productos.index'); // Volvemos a la vista de productos
        } catch (Exception $e) {
            flash('Error al crear el Producto' . $e->getMessage())->error()->important();
            return redirect()->back(); // volvemos a la anterior
        }
    }

    public function edit($id)
    {
        // Buscamos el producto por su id
        $producto = Producto::find($id);
        // Buscamos las categorias
        $categorias = Categoria::all();
        // Devolvemos el producto
        return view('productos.edit')
            ->with('producto', $producto)
            ->with('categorias', $categorias);
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
            'categoria' => 'required|exists:categorias,id',
        ]);
        try {
            // Buscamos el producto por su id
            $producto = Producto::find($id);
            // Actualizamos el producto
            $producto->update($request->all());
            // Asignamos la categoría
            $producto->categoria_id = $request->categoria;
            // salvamos el producto
            $producto->save();
            // Devolvemos el producto actualizado
            flash('Producto ' . $producto->modelo . '  actualizado con éxito.')->warning()->important();
            return redirect()->route('productos.index'); // Volvemos a la vista de productos
        } catch (Exception $e) {
            flash('Error al actualizar el Producto' . $e->getMessage())->error()->important();
            return redirect()->back(); // volvemos a la anterior
        }
    }

    public function editImage($id)
    {
        // Buscamos el producto por su id
        $producto = Producto::find($id);
        // Devolvemos el producto
        return view('productos.image')->with('producto', $producto);
    }

    public function updateImage(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            // Buscamos el producto por su id
            $producto = Producto::find($id);
            // Aquí hay que hacer lo de la imagen
            if ($producto->imagen != Producto::$IMAGE_DEFAULT && Storage::exists($producto->imagen)) {
                // Eliminamos la imagen
                Storage::delete($producto->imagen);
            }
            // Guardamos la imagen
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $fileToSave = $producto->uuid . '.' . $extension;
            $producto->imagen = $imagen->storeAs('productos', $fileToSave, 'public'); // Guardamos la imagen en el disco storage/app/public/products
            // salvamos el producto
            $producto->save();
            // Devolvemos el producto actualizado
            flash('Producto ' . $producto->modelo . '  actualizado con éxito.')->warning()->important();
            return redirect()->route('productos.index'); // Volvemos a la vista de productos
        } catch (Exception $e) {
            flash('Error al actualizar el Producto' . $e->getMessage())->error()->important();
            return redirect()->back(); // volvemos a la anterior
        }
    }


    public function destroy($id)
    {
        try {
            // Buscamos el producto por su id
            $producto = Producto::find($id);
            // Aquí hay que hacer lo de la imagen
            if ($producto->imagen != Producto::$IMAGE_DEFAULT && Storage::exists($producto->imagen)) {
                // Eliminamos la imagen
                Storage::delete($producto->imagen);
            }
            // salvamos el producto
            $producto->delete();
            // Devolvemos el producto actualizado
            flash('Producto ' . $producto->modelo . '  eliminado con éxito.')->error()->important();
            return redirect()->route('productos.index'); // Volvemos a la vista de productos
        } catch (Exception $e) {
            flash('Error al eliminar el Producto' . $e->getMessage())->error()->important();
            return redirect()->back(); // volvemos a la anterior
        }
    }
}
