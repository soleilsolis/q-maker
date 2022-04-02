<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __($queue->name) }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
   
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-5">
                
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
        $('#new').click(function(){
            $('.modal').modal('show');
        });
    </script>
</x-app-layout>
