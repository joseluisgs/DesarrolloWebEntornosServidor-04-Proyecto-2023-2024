<?php

use App\Http\Controllers\ProductoController;
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
    return view('welcome');
});

// Con el método resource() se crean todas las rutas necesarias para un CRUD y se le asociará el controlador ProductoController
Route::resource('productos', ProductoController::class);
// creamos uno especial para la imagen
Route::get('productos/{id}/edit-image', [ProductoController::class, 'editImage'])->name('productos.editImage');
Route::patch('productos/{id}/edit-image', [ProductoController::class, 'updateImage'])->name('productos.updateImage');
