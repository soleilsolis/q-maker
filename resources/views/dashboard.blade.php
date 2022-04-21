@section('title', 'Dashboard')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-5">
                @foreach($queues as $queue)
                    <a href="/queue/show/{{ $queue->id }}" class="bg-white overflow-hidden shadow-xl rounded-lg p-6 cursor-pointer">
                        <h1 class="text-2xl font-bold text-black">{{ $queue->name }}</h1>
                        <span class="text-gray-500">
                            Created {{ $carbon->parse($queue->created_at)->isoFormat('M/DD/Y') }}
                        </span>
                    </a>
                @endforeach

                <div class="border-dashed border-2 border-purple-600 overflow-hidden rounded-lg p-6 cursor-pointer hover:bg-purple-400 hover:text-white ease-in-out duration-50" id="new">
                    <h1 class="text-2xl font-bold">+ New Queue</h1>
                    <span class="text-gray-500">&nbsp;</span>
                </div>
            </div>
        </div>
    </div>

    <div class="ui small modal">
        <div class="header">New Queue</div>
        <div class="content">
            <form id="createQueue" name="createQueue" class="ui form">
                @csrf

                <div class="field">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" />
                </div>

                <div class="field">
                    <label for="unique_code">Unique Key</label>
                    <input id="unique_code" name="unique_code" type="text" />
                </div>

                <div class="field">
                    <label for="unique_code">Queue Limit</label>
                    <input id="limit" name="limit" type="number" />
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui purple circular button submit-form" data-form="createQueue" data-send="/queue/store">Create</button>
        </div>
    </div>

    <script>
        $('#new').click(function(){
            $('.modal').modal('show');
        });
    </script>
</x-app-layout>
