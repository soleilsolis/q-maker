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
            #{{ $queue->number }}
        </h1>

        <div class="ui centered header">
            {{ $current_time }}
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
