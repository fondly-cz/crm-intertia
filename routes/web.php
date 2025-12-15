<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\CompanyController;

Route::get('/', [CrmController::class, 'welcome']);

Route::resource('companies', CompanyController::class);
