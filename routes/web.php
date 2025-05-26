<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

// All listing
Route::get('/', [ListingController::class, 'index'])->name('home');

// single listing
Route::get('/index/{id}', [ListingController::class, 'show']);

// show create new listing
Route::get('/create', [ListingController::class, 'create'])->middleware('auth');

// store listing
Route::post('/store', [ListingController::class, 'store'])->middleware('auth');

// edit listing
Route::get('/edit/{id}', [ListingController::class, 'edit'])->middleware('auth');

// update listing
Route::put('/update/{id}', [ListingController::class, 'update'])->middleware('auth');

// delete listing
Route::delete('/delete/{id}', [ListingController::class, 'destroy'])->middleware('auth');

//manage listings
Route::get('/manage', [ListingController::class, 'manage'])->middleware('auth');

// show register form
Route::get('/register', [UserController::class, 'register'])->middleware('guest');

// create new user
Route::post('/users', [UserController::class, 'store']);

// logout user
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// login user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
