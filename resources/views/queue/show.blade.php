@section('title', $queue->name)

<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-4xl text-gray-800 leading-tight">
            {{ __($queue->name." - $queue->unique_code") }}
        </h1>
        <a href="/q/{{ $queue->unique_code }}" class="ui mini purple circular button" target="_blank">Live</a>
        <a href="/queue/edit/{{ $queue->id }}" class="ui mini black circular button">Edit</a>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="ui mobile reversed stackable two column grid">
                <div class="column">
                    <form id="itemCreate" name="itemCreate" class="ui form">
                        @csrf

                        <input type="hidden" name="queue_id" id="queue_id" value="{{ $queue->id }}"> 
                        <div class="field">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name">
                        </div>
                        <div class="field">
                            <label for="">Cellphone # (Optional)</label>
                            <input type="number" name="phone_number" id="phone_number">
                        </div>
                        <div class="field">
                            <input id="number" name="number" type="hidden" />
                        </div>
                        <div class="field">
                            <span class="ui large circular button purple submit-form" data-send="/item/store" data-form="itemCreate">Add</span>
                        </div>
                    </form>

                    <div class="ui divider"></div>

                    <table class="ui selectable stackable table">
                        <thead>
                            <tr>
                                <th class="collapsing">#</th>
                                <th>Name</th>
                                <th class="right aligned">Cellphone Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $i)
                                @if($loop->first)
                                    @php
                                        $first_item_id = $i->id;
                                    @endphp
                                @endif

                                <tr>
                                    <td class="collapsing">{{ $i->number }}</td>
                                    <td>{{ $i->name }}</td>
                                    <td class="right aligned">{{ $i->phone_number }}</td> 
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="column">
                    <h3 class="ui header">Current Number</h3>
                    <h2 class="ui large header" style="font-size: 4rem">
                        #{{ $item->number ?? 0 }}
                        <div class="sub header">{{ $item->name ?? '' }}</div>
                        <div class="sub header">{{ $item->phone_number ?? '' }}</div>
                    </h2>

                    @isset($items[0])
                        <button class="ui large circular button purple submit-form" data-id="{{ $queue->id }}" data-send="/queue/next">Next</button>
                    @endisset
                    
                    @isset ($item->number)
                        <button class="ui large circular button black" id="forward">Forward</button>
                    @endisset

                    @isset($first_item_id)
                        <form class="mt-5" action="">
                            <button class="ui large circular button red submit-form" data-id="{{ $first_item_id }}" data-send="/queue/emergency">Emergency Message</button>
                        </form>
                    @endisset
                </div>
            </div>
            
        </div>
    </div>

    <div class="ui small modal">
        <div class="header">Forward Queue</div>
        <div class="content">
            <form id="forwardQueue" name="forwardQueue" class="ui form">
                @csrf
                <input type="hidden" id="item_id" name="item_id" value="{{ $item->id ?? '' }}">
                <div class="field">
                    <label for="queue_id">Forward To</label>
                    <select class="ui dropdown" name="forward_queue_id" id="forward_queue_id">
                        @foreach ($queues as $queue)
                            <option value="{{ $queue->id }}">{{ $queue->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui purple circular button submit-form" data-form="forwardQueue" data-send="/item/forward">Forward</button>
        </div>
    </div>

    <script>
        $('#forward').click(function(){
            $('.modal').modal('show');
        });

        $('.dropdown').dropdown();
    </script>
</x-app-layout>
