<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivewireTestController;
use App\Http\Controllers\AlpineTestController;
use App\Http\Controllers\EventController;
use Barryvdh\Debugbar\DataCollector\EventCollector;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MyPageController;


Route::get('/', function () {
    return view('calendar');
});

Route::prefix('manager')
->middleware('can:manager-higher')
->group(function(){
    Route::get('events/past', [EventController::class, 'past'])->name('events.past');
    Route::resource('events', EventController::class);
});

Route::middleware('can:user-higher')
->group(function(){
    Route::get('/dashboard', [ReservationController::class, 'dashboard'])->name('dashboard');
    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage.index');
    Route::get('/mypage/{id}', [MyPageController::class, 'show'])->name('mypage.show');
    Route::post('/mypage/{id}', [MyPageController::class, 'cancel'])->name('mypage.cancel');
    Route::post('/{id}', [ReservationController::class, 'reserve'])->name('events.reserve');
});
Route::get('/{id}', [ReservationController::class, 'detail'])->name('events.detail');
// Route::middleware('auth')->get('/{id}', [ReservationController::class, 'detail'])->name('events.detail');


Route::controller(LivewireTestController::class)
->prefix('livewire-test')->name('livewire-test.')->group(function(){
    Route::get('index', 'index')->name('index');
    Route::get('register', 'register')->name('register');
});

Route::get('alpine-test/index', [AlpineTestController::class,'index']);


