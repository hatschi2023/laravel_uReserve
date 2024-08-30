<x-calendar-layout>
    <x-slot name="header">
        <div class="flex flex-auto">
            <!-- Logo -->
            <div class="w-20 shrink-0 flex items-center">
                <a href="/">
                    <x-application-mark class="block h-9 w-auto" />
                </a>
            </div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight px-12 pt-12 pb-4">
                イベント詳細
            </h2>
        </div>
    </x-slot>

    <div class="pt-4 pb-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                <div class="max-w-2xl py-4 mx-auto">
                    <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="py-4 font-medium text-sm text-green-600 bg-green-50">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="get" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <x-label for="event_name" value="イベント名" />
                        <div class="mx-4 mt-1">
                            {{ $event->name }}
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-label for="information" value="イベント詳細" />
                        <div class="mx-4 mt-1">
                            {!! nl2br(e($event->information)) !!}
                        </div>
                    </div>

                    <div class="md:flex justify-between">
                        <div class="mt-4">
                            <x-label for="event_date" value="イベント日付" />
                            <div class="mx-4 mt-1">
                                {{ $event->eventDate }}
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-label for="start_time" value="開始時間" />
                            <div class="mx-4 mt-1">
                                {{ $event->startTime }}
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-label for="end_time" value="終了時間" />
                            <div class="mx-4 mt-1">
                                {{ $event->endTime }}
                            </div>
                        </div>
                    </div>
                <div class="md:flex justify-between items-end">
                {{-- <div class="flex "> --}}
                    <div class="mt-4">
                        <x-label for="max_people" value="定員数" />
                        <div class="mx-4 mt-4">
                            {{ $event->max_people }}
                        </div>
                    </div>
                    <div class="ml-2 mt-4">
                            @if($reservablePeople <= 0)
                                <span class="text-s text-red-600 bg-red-100 px-2 py-2">このイベントは満員です</span>
                            @else
                            <x-label for="reserved_people" value="予約可能人数" />
                            <select class="mt-1" name="reserved_people" id="">
                                @for ($i = 1; $i <= $reservablePeople; $i++ )
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            @endif
                        </div>
                        @if ($isReserved === null)
                            <input type="hidden" name="id" value="{{ $event->id }}">
                            @if($reservablePeople > 0)
                            <x-button class="mx-4">
                                予約する
                            </x-button>
                            @endif
                        @else
                            {{-- <span class="text-s text-red-600 bg-red-100  px-2 py-2">このイベントは既に予約済みです</span> --}}
                        @endif

                    </div>
                </form>
                </div>

            </div>
        </div>
    </div>

</x-calendar-layout>
