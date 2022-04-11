@section('title', $queue->name)

<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <h1 class="ui centered large header" style="font-size: 2rem">
            {{ $queue->name }}

            <div class="sub header">
                {{ $queue->unique_code }}
            </div>
        </h1>

        <h1 class="ui centered header" style="font-size: 4rem">
            #<span class="queue_number" id="result">{{ $queue->number }}</span>
        </h1>

        <div class="ui centered header" onload="startTime()">
            <div id="txt"></div>
        </div>

        <button class="ui transition hidden submit-form" data-id="0" data-send="/x/{{ $queue->unique_code }}"></button>
    </x-jet-authentication-card>

    <script>
        setInterval(() => {
            console.log('hi')
        }, 1000);
    </script>
</x-guest-layout>
