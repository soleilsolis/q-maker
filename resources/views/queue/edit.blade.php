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
                    <div class="field">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text">
                    </div>
                </form>

                <br>
                <a class="ui purple circular button">Save</a>
                <a class="ui red circular button" target="_blank">Delete</a>


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
            </form>
        </div>
        <div class="actions">
            <button class="ui purple circular button submit-form" data-form="createQueue" data-send="/queue/store">Create</button>
        </div>
    </div>

    <script>
        $('#delete').click(function(){
            $('.modal').modal('show');
        });
    </script>
</x-app-layout>
