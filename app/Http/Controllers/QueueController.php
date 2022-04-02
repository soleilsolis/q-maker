<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Http\Requests\StoreQueueRequest;
use App\Http\Requests\UpdateQueueRequest;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQueueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Queue $queue, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'unique_code' => ['required', 'unique:queues', 'string', 'max:13' ,'regex:/^[a-zA-Z0-9]+$/u']
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'error',
                'color' => 'error'
            ]);
        }

        $queue = Queue::create([
            'name' => $request->name,
            'unique_code' => $request->unique_code,
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'reload' => 1
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function show(Queue $queue, Request $request)
    {
        $queue = Queue::findOrFail($request->id);

        if($queue->user_id != Auth::id())
        {
            return abort(404);
        }
        return view('queue.show', [
            'queue' => $queue
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function edit(Queue $queue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQueueRequest  $request
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Queue $queue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Queue $queue)
    {
        //
    }
}
