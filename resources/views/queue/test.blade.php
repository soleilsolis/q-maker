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
            <span id="date"></span>
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
    <script>
        function clockTick() {
          let currentTime = new Date(),
              month = currentTime.getMonth() + 1,
              day = currentTime.getDate(),
              year = currentTime.getFullYear(),
              hours = currentTime.getHours(),
              minutes = currentTime.getMinutes(),
              seconds = currentTime.getSeconds(),
              text = (month + "/" + day + "/" + year + ' ' + hours + ':' + minutes + ':' + seconds);
          // here we get the element with the id of "date" and change the content to the text variable we made above
          document.getElementById('date').innerHTML = text;
        }

        // here we run the clockTick function every 1000ms (1 second)
        setInterval(clockTick, 1000);
    </script>
</x-guest-layout>
