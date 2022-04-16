<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQueueRequest;
use App\Http\Requests\UpdateQueueRequest;

use App\Models\Queue;
use App\Models\Item;

use Carbon\Carbon;

use Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Twilio\Rest\Client;

class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reset()
    {
        $queues = Queue::all();

        foreach ($queues as $queue) {
            $queue->number = 0;
            $queue->save();
        }
    }

    public function live(Request $request)
    {
        $queue = Queue::where('unique_code','=',$request->unique_code)->first();

        return response()->json([
            'data' => [
                'queue_number' => $queue->number
            ]
        ]);
    }

    public function public(Request $request)
    {
        $queue = Queue::where('unique_code','=',$request->unique_code)->first();
        
        return view('queue.test',[
            'queue' => $queue,
            'current_time' => Carbon::now(),
            'minutes' => Carbon::now()->isoFormat('m'),
            'seconds' => Carbon::now()->isoFormat('s'),
            'hours' => Carbon::now()->isoFormat('H'),
        ]);   
    }

    public function next(Request $request)
    {
        $now = Carbon::now()->format('Y-m-d');

        $queue = Queue::findOrFail($request->id);
        $queue->number++;

        if($queue->number+3)
        {
            $item = Item::where('queue_id', '=', $queue->id)
                ->where('number', '=', $queue->number+3)
                ->where(DB::raw('date(created_at)'), '=', $now)
                ->orderBy('created_at', 'desc')
                ->first();
        
            if($item && $item->phone_number)
            {
                $sid = 'AC7f1969a745b9e0f8c4fe3b3e3bffc4e5';
                $token = 'c00f5727a6be4ab835e5ee2069ee0a30';
                $client = new Client($sid, $token);

                // Use the client to do fun stuff like send text messages!
                $client->messages->create(
                    // the number you'd like to send the message to
                    '+63'.ltrim($item->phone_number,'0'),
                    [
                        // A Twilio phone number you purchased at twilio.com/console
                        'from' => '+15076985456',
                        // the body of the text message you'd like to send
                        'body' => "\nHi Mr/Mrs. {$item->name}, Thank you for waiting!\n\nYour Queue number {$item->number} will be called soon.\nPlease proceed to the Queue Area.\n\nPlease go to this page if you wish to keep an eye on the queue screen.\nhttps://rtuqmaker.xyz/q/{$queue->unique_code}\n\nThis is the reminder that your queue number will be invalid if you will be exceeded in the queue. Thank you!"
                    ]
                );
            }
        }
 
        $queue->save();

        return response()->json([
            'reload' => 1
        ]);
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
        $message = ['regex' => 'The unique code format is invalid. <br> Allowed: alpha-numeric characters (small letters, capital letters and numbers)'];
        
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'unique_code' => ['required', 'unique:queues', 'string', 'max:13' ,'regex:/^[a-zA-Z0-9]+$/u']
        ],$message);

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
        $now = Carbon::now()->format('Y-m-d');

        $items = Item::where('queue_id', '=', $queue->id)
            ->where('number', '>', $queue->number)
            ->where(DB::raw('date(created_at)'), '=', $now)
            ->orderBy('number', 'asc')
            ->get();
        
        if($queue->number)
        {
            $item = Item::where('queue_id', '=', $queue->id)
                ->where('number', '=', $queue->number)
                ->where(DB::raw('date(created_at)'), '=', $now)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if($queue->user_id != Auth::id())
        {
            return abort(404);
        }

        return view('queue.show', [
            'queue' => $queue,
            'item' => $item ?? null,
            'items' => $items
        ]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function edit(Queue $queue, Request $request)
    {
        $queue = Queue::findOrFail($request->id);
        
        if($queue->user_id != Auth::id())
        {
            return abort(404);
        }

        return view('queue.edit', [
            'queue' => $queue,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQueueRequest  $request
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'unique_code' => [
                'required', 
                Rule::unique('queues')->ignore($request->id),
                'string', 
                'max:13' ,
                'regex:/^[a-zA-Z0-9]+$/u'
            ]
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'error',
                'color' => 'error'
            ]);
        }

        $queue = Queue::findOrFail($request->id);
        $queue->name = $request->name;
        $queue->unique_code = $request->unique_code;
        $queue->save();

        return response()->json([
            'reload' => 1,
            'message' => 'Changes Saved',
            'color' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $queue = Queue::findOrFail($request->id);
        $queue->forceDelete();

        return response()->json([
            'redirect' => 1,
            'url' => '/dashboard'
        ]);
    }
}
