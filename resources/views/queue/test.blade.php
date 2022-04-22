@section('title', $queue->name)

<x-guest-layout>
    <input type="hidden" name="queue_number" id="queue_number">
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

        <h1 class="ui centered header" style="font-size: 17rem">
            <span class="queue_number">{{ $queue->number }}</span>
        </h1>

        <div class="ui centered header">
            <span id="date"></span>
        </div>

        <button id="updateQueueNumber" class="ui transition hidden submit-form" data-id="0" data-send="/x/{{ $queue->unique_code }}"></button>
    </x-jet-authentication-card>

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

        setInterval(() => {
            console.log($('#updateQueueNumber').click())
            
        }, 1000);
    </script>
</x-guest-layout>
