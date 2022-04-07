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
            # <span id="result">{{ $queue->number }}</span>
        </h1>

        <div class="ui centered header" onload="startTime()">
            <div id="txt"></div>
        </div>
    </x-jet-authentication-card>

    <script>
        if(typeof(EventSource) !== "undefined") {
          var source = new EventSource("/x/{{ $queue->unique_code }}");
          source.onmessage = function(event) {
            document.getElementById("result").innerHTML = event.data + "<br>";
          };
        } else {
          document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
        }

    </script>
 
</x-guest-layout>
