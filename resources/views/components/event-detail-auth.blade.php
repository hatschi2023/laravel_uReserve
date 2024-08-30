<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント詳細
        </h2>
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

                <form method="post" action="{{ route('events.reserve', ['id' => $event->id ]) }}">
                    @csrf
                    <div  class="mt-4">
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
                        <div class="mt-4">
                            <x-label for="max_people" value="定員数" />
                            <div class="mx-4 my-2">
                                {{ $event->max_people }}
                            </div>
                        </div>
                        @if ($reservablePeople <= 0)
                            <span class="text-s text-red-600 bg-red-100 mx-4 px-4 py-2">このイベントは満員です</span>
                        @endif
                        @if ($event->eventDate  >= now()->format('Y年m月d日'))
                            <div class="mt-4">
                            <x-label for="reserved_people" value="予約可能人数" />
                            <select class="mx-4 mt-1" name="reserved_people" id="">
                                @for ($i = 1; $i <= $reservablePeople; $i++ )
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            </div>
                        @endif
                        {{-- @dd($event->eventDate, now()->format('Y年m月d日'), $event->eventDate >= now()->format('Y年m月d日')) --}}

                        @if (is_null($isReserved) && $event->eventDate >= now()->format('Y年m月d日'))
                            <input type="hidden" name="id" value="{{ $event->id }}">
                            @if($reservablePeople > 0)
                            <x-button class="mx-4">
                                予約する
                            </x-button>
                            @endif
                        @elseif (($isReserved) ==! null)
                            <span class="text-s text-red-600 bg-red-100  px-4 py-2">予約済み</span>

                        @endif
                        </div>
                    </div>
                </form>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
