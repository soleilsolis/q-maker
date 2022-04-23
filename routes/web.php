<?php
use App\Models\Queue;
use App\Models\Item;

use App\Http\Controllers\QueueController;
use App\Http\Controllers\ItemController;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;





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

Route::post('x/{unique_code}', [QueueController::class, 'live']);
Route::get('q/{unique_code}', [QueueController::class, 'public']);
Route::get('/reset', [QueueController::class, 'reset']);

Route::middleware(['auth:sanctum', 'verified'])->group(function (){
    Route::get('/dashboard', function () {
        return view('dashboard',[
            'queues' => Queue::where('user_id', '=', Auth::id())->get(),
            'carbon' => new Carbon
        ]);
    })->name('dashboard');

    Route::get('/stats', function(Request $request){

        $queues = Queue::where('user_id','=',Auth::id())->get(); 

        $stats = [];
        $dates = [];

        $from = $request->from ? Carbon::parse($request->from) : Carbon::now()->subDays(10);
        $to = $request->to ? Carbon::parse($request->to) : Carbon::now();


        $difference = $from->diffInDays($to);
        $x = 0;

        foreach ($queues as $queue) 
        {      
            for($days = 0; $days < $difference+1; $days++)
            {
                $dt = Carbon::parse($from);

                $dt = $dt->addDays($days)->isoFormat('YYYY-MM-DD');
                $item = Item::where('queue_id', '=', $queue->id)
                        ->where(DB::raw('DATE(created_at)'),'=',$dt)->count();
                $stats[$queue->name][] = $item;

                if(!$x)
                {
                    $dates[] = $dt; 
                }
            } 

            $x = 1;
        }

        return view('stats', [
            'stats' => $stats,
            'from' => $from->isoFormat('YYYY-MM-DD'),
            'to' => $to->isoFormat('YYYY-MM-DD'),
            'dates' => $dates

        ]);
    })->name('stats');

    Route::prefix('queue')->group(function () {
        Route::get('show/{id}', [QueueController::class, 'show'])->whereNumber('id');
        Route::get('edit/{id}', [QueueController::class, 'edit'])->whereNumber('id');
        Route::post('update/{id}', [QueueController::class, 'update'])->whereNumber('id');
        Route::post('delete/{id}', [QueueController::class, 'destroy'])->whereNumber('id');

        Route::post('/store', [QueueController::class, 'store']);
        Route::post('/next', [QueueController::class, 'next']);
        Route::post('/emergency', [QueueController::class, 'emergency']);
    }); 

    Route::prefix('item')->group(function () {
        Route::post('/store', [ItemController::class, 'store']);
        Route::post('/forward', [ItemController::class, 'forward']);
    });
});
