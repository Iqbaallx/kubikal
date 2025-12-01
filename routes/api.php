<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GaleriController;

Route::post('/admin/register', [AdminController::class, 'register']);
Route::post('/admin/login', [AdminController::class, 'login']);

Route::get('/menu', [MenuController::class, 'index']);
Route::get('/menu/{id}', [MenuController::class, 'show']);
Route::post('/menu', [MenuController::class, 'store']);
Route::put('/menu/{id}', [MenuController::class, 'update']);
Route::delete('/menu/{id}', [MenuController::class, 'destroy']);

Route::get('/event', [EventController::class, 'index']);
Route::get('/event/{id}', [EventController::class, 'show']);
Route::post('/event', [EventController::class, 'store']);
Route::put('/event/{id}', [EventController::class, 'update']);
Route::delete('/event/{id}', [EventController::class, 'destroy']);

Route::get('/galeri', [GaleriController::class, 'index']);
Route::post('/galeri', [GaleriController::class, 'store']);
Route::patch('/galeri/{id}/status', [GaleriController::class, 'updateStatus']);
Route::delete('/galeri/{id}', [GaleriController::class, 'destroy']);
