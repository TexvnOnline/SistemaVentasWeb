<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\SistemaVentas;
Route::GET('/', [PrincipalController::class, 'Login'])->name('login.menu');
Route::GET('/iniciar_sesion/validar', [PrincipalController::class, 'validarUsuario'])->name('login.validarUsuario');
Route::get('/menu_principal', [PrincipalController::class, 'home'])->name('home');
Route::get('/cerrar_sesion', [PrincipalController::class, 'cerrar_sesion'])->name('cerrar_sesion');
// --------------------------------------- SISTEMA DE VENTAS ---------------------------------------------
Route::GET('/SistemaOrtopedia_principal', [PrincipalController::class, 'Sistema'])->name('menu.index');
Route::GET('/sistema_ventas/ventas', [VentasController::class, 'Ventas'])->name('sistema.ventas');
Route::POST('/sistema_ventas/venta/guardar', [VentasController::class, 'guardar_venta'])->name('sistema.ventas.guardar');
Route::GET('/sistema_ventas/almacen', [SistemaVentas::class, 'Almacen'])->name('sistema.almacen');
Route::POST('/sistema_ventas/almacen/guardar', [SistemaVentas::class, 'guardar_producto'])->name('sistema.almacen.guardar');
// --------------------------------------- MANTENIMIENTO ---------------------------------------------
Route::GET('/mantenimiento/usuarios', [MantenimientoController::class, 'Usuarios'])->name('mantenimiento.usuarios');
Route::POST('/mantenimiento/usuarios/verificar', [MantenimientoController::class, 'verificar_usuario'])->name('usuarios_gestion.verificar');
Route::POST('/mantenimiento/usuarios/guardar', [MantenimientoController::class, 'guardar_usuario'])->name('usuarios_gestion.guardar');
Route::POST('/mantenimiento/usuarios/cesar', [MantenimientoController::class, 'cesar_usuario'])->name('usuarios_gestion.cesar');
Route::GET('/mantenimiento/proveedores', [MantenimientoController::class, 'Proveedores'])->name('mantenimiento.proveedores');
Route::POST('/mantenimiento/proveedores/guardar', [MantenimientoController::class, 'guardar_proveedo'])->name('proveedores.guardar');
Route::POST('/mantenimiento/proveedores/eliminar', [MantenimientoController::class, 'eliminar_proveedor'])->name('proveedores.eliminar');
Route::GET('/mantenimiento/doctores', [MantenimientoController::class, 'Doctores'])->name('mantenimiento.doctores');
Route::POST('/mantenimiento/doctores/eliminar', [MantenimientoController::class, 'eliminar_usuario'])->name('usuarios_gestion.eliminar');
// --------------------------------------- REPORTES ---------------------------------------------
Route::GET('/sistema_ventas/reportes/historial_ventas', [VentasController::class, 'historial_ventas'])->name('sistema.ventas.historial');
Route::GET('/sistema_ventas/reportes/clientes', [VentasController::class, 'historial_clientes'])->name('sistema.clientes.historial');