<div class="rounded-t">
<div class="text-center text-sm pt-4 pb-2 bg-gray-200 rounded-t">
    日付を選択してください。本日から最大30日先まで選択できます。
    <input id="calendar" class="block mt-1 mb-1 mx-auto rounded bg-white" type="text" name="calendar" value="{{ $currentDate }}"
    wire:change="getDate($event.target.value)" />
</div>

<div class="flex mx-auto">
    <div class="pl-2 bg-gray-200"></div>
    <x-calendar-time />
    @for ($i = 0; $i < 7; $i++)

    <div class="w-32">
        <div class="py-1 px-2 border border-gray-200 text-center bg-gray-100">{{ $currentWeek[$i]['day'] }}</div>
        <div class="py-1 px-2 border border-gray-200 text-center bg-gray-100">{{ $currentWeek[$i]['dayOfWeek'] }}</div>

            @for ($j = 0; $j < 21; $j++)
                @if($events->isNotEmpty())
                    @php
                        $event = $events->firstWhere('start_date', $currentWeek[$i]['checkDay'] . " " . \Constant::EVENT_TIME[$j]);
                        // @dd($event);
                    @endphp
                    @if(is_null($event))
                        <div class="py-1 px-2 h-8 border border-gray-200"></div>
                        @continue
                    @endif
                    @if(!is_null($event->deleted_at))
                        <div class="py-1 px-2 h-8 border border-gray-200"></div>
                        @continue
                    @endif
                    @php
                        $eventId = $event->id;
                        $eventName = $event->name;
                        $eventInfo = \App\Models\Event::with('reservations')
                            ->where('id', $eventId)
                            ->first();
                        $eventPeriod = \Carbon\Carbon::parse($eventInfo->start_date)->diffInMinutes($eventInfo->end_date) / 30 - 1;//イベント名に1ます（30分）使用するため-1

                        // ログインユーザーの最新の予約状態を取得
                        $latestReservation = $eventInfo->reservations
                            ->where('user_id', Auth::id())
                            ->sortByDesc('created_at')
                            ->first();
                        $isUserReserved = $latestReservation && is_null($latestReservation->canceled_date);//trueなら予約中
                        $isCanceled = $latestReservation && !is_null($latestReservation->canceled_date);//trueならキャンセル済
                    @endphp

                    {{-- イベント名＋対象マスに背景色設定 --}}
                    <a href="{{ route('events.detail', ['id' => $eventId]) }}">
                        <div class="py-1 px-2 h-8 border border-gray-200 text-xs {{ $isUserReserved ?  ($isCanceled ? 'bg-cyan-100' : 'bg-rose-200') : 'bg-cyan-100' }}">
                        {{ $eventName }}
                        </div>
                    </a>
                    {{-- イベントが30分以上のとき対象マスに背景色設定 --}}
                    @if ( $eventPeriod > 0 )
                        @for($k = 0; $k < $eventPeriod ; $k++)
                        <div class="py-1 px-2 h-8 border border-gray-200 {{ $isUserReserved ?  ($isCanceled ? 'bg-cyan-100' : 'bg-rose-200') : 'bg-cyan-100' }}">
                        </div>

                        @endfor
                        @php $j += $eventPeriod @endphp
                    @endif
                @else
                    <div class="py-1 px-2 h-8 border border-gray-200"></div>
                @endif
            @endfor
        </div>
    @endfor
    <div class="pl-2 bg-gray-200"></div>
</div>
<div class="pt-2 bg-gray-200"></div>
</div>
