<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CrackingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\PasswordReset;

// use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




//Parti Admin


    Route::get('/admin', [AdminController::class, 'getFullUsers']);
    Route::get('/adminproject', [AdminController::class, 'getFullUsersProject']);


//


//Authentification token
Route::post('/login',[AuthController::class,'authenticate']);



Route::get('/reset-password/{token}',[NewPasswordController::class,'create'])->name('newpassword.create');
Route::post('/reset-password',[NewPasswordController::class,'show'])->name('newpassword.show');

//Route user
Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->where('id', '[0-9]+');
Route::post('/users',[UserController::class, 'store'])->name('users.store');
Route::get('/users/edit',[UserController::class, 'edit']) -> name('users.edit')->middleware('auth:sanctum');
// Route::get('/me',[UserController::class, 'edit']) -> name('users.edit');
Route::put('/users/{id}',[UserController::class, 'update']) -> name('users.update');



//Fin de Route user


//Route Project
Route::middleware('auth:sanctum')->group(function() {

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create')->where('id', '[0-9]+');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
// Route::get('/projects', [ProjectController::class,'show'])->name('projects.show');
Route::get('/projects/{id}/edit', [ProjectController::class,'edit'])->name('projects.edit');
Route::delete('/projects', [ProjectController::class,'destroy'])->name('projects.delete');
});

//Fin Route Project


Route::middleware('auth:sanctum')->group(function() {
    //Routes contacts
    Route::post('/invitation', [ContactController::class, 'invitation'])->name('contacts.destroy');
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create')->where('id', '[0-9]+');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
    //Fin Route contact

    //Routes craquages
    Route::get('/test',[ContactController::class, 'helpcontact'])->name('contacts.helpcontact');
    Route::post('/craques', [CrackingController::class, 'store'])->name('craques.store');
    
    Route::get('/dashboard/stats', [DashboardController::class,'getStats'])->name('dashboard.stats');
});

