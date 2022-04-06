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

        <div class="ui centered header">
            <span id="hours"></span>:<span id="minutes"></span>:<span id="seconds"></span>
           
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

        let sec = {{ $seconds }};
        let min = {{ $minutes }};
        let hour = {{ $hours }};
        function pad ( val ) { return val > 9 ? val : "0" + val; }
        setInterval( function(){
            let x = parseInt(sec / 60 % 60, 10)+min >= 60 ? '00' : pad(parseInt(sec / 60 % 60, 10)+min);

            document.getElementById("seconds").innerHTML=pad(++sec%60);
            document.getElementById("minutes").innerHTML = x;
            document.getElementById("hours").innerHTML= pad(parseInt(sec / 3600 % 60, 10)+hour); 
        }, 1000);
    </script>
</x-guest-layout>
