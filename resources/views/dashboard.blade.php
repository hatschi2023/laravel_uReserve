<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           イベントカレンダー
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="event-calendar mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                @if (session('status'))
                    <div class="px-4 py-2 text-bold font-medium text-sm text-green-600 bg-green-50">
                        {{ session('status') }}
                    </div>
                @endif
                @livewire('calendar')
            </div>
        </div>
    </div>
</x-app-layout>
