@section('title', $queue->name)

<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-4xl text-gray-800 leading-tight">
            {{ __("$queue->name - $queue->unique_code") }}
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="ui two column stackable grid">
            <div class="column">
                <form id="editQueue" name="editQueue" class="ui form">
                    @csrf
                    <div class="field">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" value="{{ $queue->name }}">
                    </div>
                    <div class="field">
                        <label for="unique_code">Unique Code</label>
                        <input id="unique_code" name="unique_code" type="text" value="{{ $queue->unique_code }}">
                    </div>
                </form>

                <br>
                <button class="ui purple circular button submit-form" data-form="editQueue" data-send="/queue/update/{{ $queue->id }}">Save</button>
                <a id="delete" class="ui red circular button" target="_blank">Delete</a>
            </div>
        </div>
    </div>

    <div class="ui mini modal">
        <div class="header">Delete Queue</div>
        <div class="content">Are you sure? This cannot be undone!</div>
        <div class="actions">
            <button class="ui circular black button">No</button>
            <button class="ui circular red button submit-form" data-form="editQueue" data-send="/queue/delete/{{ $queue->id }}">Yes</button>
        </div>
    </div>

    
</x-app-layout>
<script>
    $('#delete').click(function(){
        $('.modal').modal('show');
    });
</script>