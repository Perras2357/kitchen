<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConnexionController;
use App\Models\UserModel;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\GetComponentController;
use App\Http\Controllers\GetUserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::match (['get', 'post'],'/connexion', [ConnexionController::class, 'connexion'])->name('connexion');
Route::match (['get', 'post'],'/inscription', [InscriptionController::class, 'inscription'])->name('inscription');
Route::match (['get', 'post'],'/getComponent', [GetComponentController::class, 'getComponent'])->name('getComponent');
Route::match (['get', 'post'],'/getUser', [GetUserController::class, 'getUser'])->name('getUser');


