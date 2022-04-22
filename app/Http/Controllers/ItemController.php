<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Queue;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function forward(Request $request, Item $item)
    {
        $now = Carbon::now()->format('Y-m-d');

        $queue = Queue::findOrFail($request->forward_queue_id);

        $forward_item = Item::where('queue_id', '=', $request->forward_queue_id)
                    ->where(DB::raw('date(created_at)'),'=',$now)
                    ->orderBy('number', 'desc');

        if($queue->limits && $queue->limits == $forward_item->count())
        {
            return response()->json([
                'errors' => ['number' => 'The limit for this queue has been reached'],
                'message' => 'error',
                'color' => 'error'
            ]);
        }

        $forward_item = $forward_item->first();

        $item = Item::find($request->item_id);

        Item::create([
            'name' => $item->name,
            'number' => !empty($forward_item->number) ? $forward_item->number+1 : 1,
            'queue_id' => $request->forward_queue_id,
            'phone_number' => $item->phone_number
        ]);

        $current_queue = $item->queue;
        $current_queue->number++;
        $current_queue->save();

        return response()->json([
            'reload' => 1,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $now = Carbon::now()->format('Y-m-d');

        $validator = Validator::make($request->all(), [
            'queue_id' => ['required'],
            'name' => ['required','string','max:255'],
            'phone_number' => ['nullable','regex:/(09)[0-9]{9}/', 'max:11']
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'error',
                'color' => 'error'
            ]);
        }

        $queue = Queue::where('user_id', '=', Auth::id())
                    ->where('id', '=', $request->queue_id)
                    ->first();

        if(!$queue)
        {
            abort(404);
        }

        $item = Item::where('queue_id', '=', $request->queue_id)
                    ->where(DB::raw('date(created_at)'),'=',$now)
                    ->orderBy('number', 'desc');

        if($queue->limits && $queue->limits == $item->count())
        {
            return response()->json([
                'errors' => ['number' => 'The limit for this queue has been reached'],
                'message' => 'error',
                'color' => 'error'
            ]);
        }

        $item = $item->first();

        Item::create([
            'name' => $request->name,
            'number' => !empty($item->number) ? $item->number+1 : 1,
            'queue_id' => $request->queue_id,
            'phone_number' => $request->phone_number
        ]);

        return response()->json([
            'reload' => 1,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
