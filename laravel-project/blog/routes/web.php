<?php

use App\Http\Controllers\UserController4;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController10;
use App\Http\Controllers\MailController;

Route::match(['get', 'post'], '/crudgetdata', [UserController4::class, 'index'])->name('crud.index');
Route::post('/update-user/{id}', [UserController4::class, 'ajaxUpdate'])->name('crud.ajaxUpdate');
Route::delete('/delete-user/{id}', [UserController4::class, 'ajaxDelete'])->name('crud.ajaxDelete');
Route::delete('/delete-multiple-users', [UserController4::class, 'ajaxDeleteMultiple'])->name('crud.ajaxDeleteMultiple');
Route::get('/get-table-data', [UserController4::class, 'getTableData'])->name('crud.getTableData');
