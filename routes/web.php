<?php

use App\Http\Controllers\pageController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\PolygonsController;
use App\Http\Controllers\PolylinesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/peta', [pageController::class, 'peta'])->name('peta');

Route::get('/tabel', [pageController::class, 'tabel'])->name('tabel');

Route::post('/points', [PointsController::class, 'store'])
->name('points.store');

Route::delete('/delete-points/{id}', [PointsController::class, 'destroy'])
->name('points.delete');

Route::post('/polylines', [PolylinesController::class, 'store'])
->name('polylines.store');

Route::delete('/delete-polylines/{id}', [PolylinesController::class, 'destroy'])
    ->name('polylines.delete');

Route::post('/polygons', [PolygonsController::class, 'store'])
->name('polygons.store');

Route::delete('/delete-polygons/{id}', [PolygonsController::class, 'destroy'])
    ->name('polygons.delete');

Route::get('/geojson/points', [PointsController::class, 'geojson'])
    ->name('geojson.points');

Route::get('/geojson/polylines', [PolylinesController::class, 'geojson'])
    ->name('geojson.polylines');

Route::get('/geojson/polygons', [PolygonsController::class, 'geojson'])
    ->name('geojson.polygons');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
