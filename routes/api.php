<?php

use App\Http\Controllers\OfficeController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Tags
Route::get('/tags', TagController::class);

//Offices
Route::get('/offices', [OfficeController::class, 'index']);
Route::get('/offices/{office}', [OfficeController::class, 'show']);
Route::post('/offices', [OfficeController::class, 'create'])
     ->middleware(['auth:sanctum', 'verified']);


