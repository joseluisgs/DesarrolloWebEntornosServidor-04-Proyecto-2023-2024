<?php

use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('productos.index');
});

// Con el método resource() se crean todas las rutas necesarias para un CRUD y se le asociará el controlador ProductoController
/*Route::resource('productos', ProductoController::class)
    ->middleware('auth');
// creamos uno especial para la imagen
Route::get('productos/{producto}/edit-image', [ProductoController::class, 'editImage'])->name('productos.editImage')
    ->middleware('auth');
Route::patch('productos/{producto}/edit-image', [ProductoController::class, 'updateImage'])
    ->name('productos.updateImage')->middleware('auth');*/


// Vamos a descomponer la de Productos porque hay cosas que no necesitan autenticación
// Agrupamos las rutas con el prefijo 'productos'
Route::group(['prefix' => 'productos'], function () {

    // Index: Muestra una lista de todos los productos
    Route::get('/', [ProductoController::class, 'index'])->name('productos.index');

    // Create: Muestra un formulario para crear un nuevo producto
    Route::get('/create', [ProductoController::class, 'create'])->name('productos.create')->middleware(['auth', 'admin']);

    // Store: Guarda el nuevo producto en la base de datos
    Route::post('/', [ProductoController::class, 'store'])->name('productos.store')->middleware(['auth', 'admin']);

    // Show: Muestra un producto específico
    Route::get('/{producto}', [ProductoController::class, 'show'])->name('productos.show');

    // Edit: Muestra un formulario para editar un producto existente
    Route::get('/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit')->middleware(['auth', 'admin']);

    // Update: Actualiza un producto en la base de datos
    Route::put('/{producto}', [ProductoController::class, 'update'])->name('productos.update')->middleware(['auth', 'admin']);

    // Destroy: Elimina un producto de la base de datos
    Route::delete('/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy')->middleware(['auth', 'admin']);

    // Edit Image: Muestra un formulario para editar la imagen de un producto
    Route::get('/{producto}/edit-image', [ProductoController::class, 'editImage'])->name('productos.editImage')->middleware(['auth', 'admin']);

    // Update Image: Actualiza la imagen de un producto en la base de datos
    Route::patch('/{producto}/edit-image', [ProductoController::class, 'updateImage'])->name('productos.updateImage')->middleware(['auth', 'admin']);

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
