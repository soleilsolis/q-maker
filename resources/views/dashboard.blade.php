<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-5">
                <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                    <h1 class="text-2xl font-bold">Registrar</h1>
                    <span class="text-gray-500">Created 02/06/2021</span>
                </div>
                <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                    <h1 class="text-2xl font-bold">Library</h1>
                    <span class="text-gray-500">Created 02/06/2021</span>
                </div>
                <div class="border-dashed border-2 hover:border-red-500 overflow-hidden rounded-lg p-6 ">
                    <h1 class="text-2xl font-bold">
                        + New Queue
                    </h1>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
