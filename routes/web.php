<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);
Route::get('/top', [App\Http\Controllers\TopController::class, 'index']);

Route::get('/login', [App\Http\Controllers\LoginController::class, 'index']);
Route::post('/login/sign_in', [App\Http\Controllers\LoginController::class, 'sign_in']); // 追加
Route::post('/login/register', [App\Http\Controllers\LoginController::class, 'register']);
Route::get('/login/unregister', [App\Http\Controllers\LoginController::class, 'unregister']);

// 以下にToDoアプリ用のルートを記述する
// getは普通のアクセスの場合に使う。
Route::get('/todo', [App\Http\Controllers\TaskController::class, 'index']);
// postは入力フォームにデータを入れてもらった場合などに使う。
Route::post('/todo', [App\Http\Controllers\TaskController::class, 'store']);
Route::delete('/todo/{id}', [App\Http\Controllers\TaskController::class, 'destroy']);
// ▼ ここから編集機能用のルートを追加
Route::get('/todo/{id}/edit', [App\Http\Controllers\TaskController::class, 'edit']);
Route::put('/todo/{id}', [App\Http\Controllers\TaskController::class, 'update']);

