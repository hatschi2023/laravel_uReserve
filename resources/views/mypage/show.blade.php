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
                    <div class="px-4 py-4 font-medium text-sm text-green-600 bg-green-50">
                        {{ session('status') }}
                    </div>
                    @endif

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

                    <form id="cancel_{{ $event->id }}" method="post" action="{{ route('mypage.cancel', ['id' => $event->id ]) }}">
                        @csrf
                    <div class="md:flex justify-between items-end">
                        <div class="mt-4">
                            <x-label value="予約人数" />
                            <div class="mx-4 mt-1">
                                {{ $reservation->number_of_people }}
                            </div>
                        </div>
                        @if($event->eventDate >= \Carbon\Carbon::today()->format('Y年m月d日'))
                        <a href="#" data-id="{{ $event->id }}" onclick="cancelPost(this)"
                            class="inline-flex items-center justify-center h-12 w-28 bg-gray-500 rounded-md font-semibold text-white hover:bg-gray-600 focus:bg-gray-600">
                            キャンセルする
                        </a>
                        @endif
                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function cancelPost(e) {
            'use strict';
            if (confirm('本当にキャンセルしてもよろしいですか？')) {
                document.getElementById('cancel_' + e.dataset.id).submit();
            }
        }
    </script>


</x-app-layout>
