<?php

use Illuminate\Support\Facades\Route;

// Arranca en /api

// Route::get('/', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/', function () {
    return response()->json(['root' => true]);
});
