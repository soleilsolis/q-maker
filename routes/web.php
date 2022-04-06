<?php

use App\Http\Controllers\QueueController;
use App\Http\Controllers\ItemController;

use App\Models\Queue;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('q/{unique_code}', [QueueController::class, 'public']);
Route::get('x/{unique_code}', [QueueController::class, 'sse']);


Route::middleware(['auth:sanctum', 'verified'])->group(function (){
    Route::get('/dashboard', function () {
        return view('dashboard',[
            'queues' => Queue::where('user_id', '=', Auth::id())->get(),
            'carbon' => new Carbon
        ]);
    })->name('dashboard');

    Route::prefix('queue')->group(function () {
        Route::get('show/{id}', [QueueController::class, 'show'])
            ->whereNumber('id');

        Route::post('/store', [QueueController::class, 'store']);

        Route::post('/next', [QueueController::class, 'next']);
    }); 

    Route::prefix('item')->group(function () {
        Route::post('/store', [ItemController::class, 'store']);
    });
});

Route::middleware(['auth:sanctum', 'verified'])->get('/test', function () {
    return view('test');
})->name('test');
