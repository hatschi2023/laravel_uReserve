<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\CarbonImmutable;
use App\Services\EventService;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Calendar extends Component
{
    public $currentDate;
    public $currentWeek;
    public $day;
    public $checkDay;

    public $sevenDaysLater;
    public $events;
    public $userReservedEvents;
    public $dayOfWeek;

    public function mount()
    {
        $this->currentDate = CarbonImmutable::today();
        $this->sevenDaysLater = $this->currentDate->addDays(7);
        $this->currentWeek =[];

        // 全てのイベントを取得
        $this->events = EventService::getWeekEvents(
            $this->currentDate->format('Y-m-d'),
            $this->sevenDaysLater->format('Y-m-d')
        );
        // dd("初回:" , $this->events);

        // ログインしているときのみユーザーの予約イベントを取得
        $userId = Auth::id();
        $this->userReservedEvents = $userId ? EventService::getUserReservedEvents($userId,
            $this->currentDate->format('Y-m-d'),
            $this->sevenDaysLater->format('Y-m-d'))
        : collect();
        // Log::info($this->userReservedEvents); // ここでログ出力

        // 週ごとの日付と曜日を設定
        for($i = 0; $i < 7; $i++){
            $this->day = CarbonImmutable::today()->addDays($i)->format('m月d日');
            $this->checkDay = CarbonImmutable::today()->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = CarbonImmutable::today()->addDays($i)->dayName;
            array_push($this->currentWeek,
                [
                    'day' => $this->day,
                    'checkDay' => $this->checkDay,
                    'dayOfWeek' => $this->dayOfWeek,
                ]);
        }
    }

    public function getDate($date)
    {
        $this->currentDate =$date;
        $this->currentWeek = [];
        $this->sevenDaysLater = CarbonImmutable::parse($this->currentDate)->addDays(7);

        // 全てのイベントを再取得
        $this->events = EventService::getWeekEvents(
            $this->currentDate,
            $this->sevenDaysLater->format('Y-m-d'),
        );
        // dd("再:" , $this->events);


        // ログインしているときのみユーザーの予約イベントを再取得
        $userId = Auth::id();
        $this->userReservedEvents = $userId ? EventService::getUserReservedEvents($userId,
            $this->currentDate,
            $this->sevenDaysLater->format('Y-m-d'))
        : collect();

        // 週ごとの日付と曜日を再設定
        for($i = 0; $i<7; $i++){
            $this->day = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('m月d日');
            $this->checkDay = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = CarbonImmutable::parse($this->currentDate)->addDays($i)->dayName;

            array_push($this->currentWeek,
                [
                'day' => $this->day,
                'checkDay' => $this->checkDay,
                'dayOfWeek' => $this->dayOfWeek,
                ]);
        }
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
