@section('title', $queue->name)

<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-4xl text-gray-800 leading-tight">
            {{ __($queue->name." - $queue->unique_code") }}
        </h1>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="ui mobile reversed stackable two column grid">
                <div class="column">
                    <div class="ui form">
                        <div class="field">
                            <label for="">Name</label>
                            <input type="text" name="" id="">
                        </div>
                        <div class="field">
                            <label for="">Cellphone # (Optional)</label>
                            <input type="number" name="" id="">
                        </div>
                        <div class="field">
                            <button class="ui large circular button purple">Add</button>
                        </div>
                    </div>

                    <div class="ui divider"></div>

                    <table class="ui selectable stackable table">
                        <thead>
                            <tr>
                                <th class="collapsing">#</th>
                                <th>Name</th>
                                <th class="right aligned">Cellphone Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="collapsing">1</td>
                                <td>John Doe</td>
                                <td class="right aligned">09152041574</td> 
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="column">
                    <h3 class="ui header">Current Number</h3>
                    <h2 class="ui large header" style="font-size: 4rem">#{{ $queue->number }}</h2>
                    <button class="ui large circular button purple submit-form" data-id="{{ $queue->id }}" data-send="/queue/next">Next</button>

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
