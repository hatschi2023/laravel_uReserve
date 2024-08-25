<x-calendar-layout>
    {{-- <div class="min-h-screen bg-cover bg-center"> --}}
    <x-slot name="header">
        <div class="flex ">
            <!-- Logo -->
            <div class="w-20 shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-mark class="block h-9 w-auto" />
                </a>
            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight pl-12 pt-12">
                イベントカレンダー
             </h2>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="event-calendar mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              @livewire('calendar')
          </div>
        </div>
    </div>
</x-calendar-layout>
