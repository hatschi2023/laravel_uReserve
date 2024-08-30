<?php

namespace App\Services;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EventService
{
    public static function checkEventDuplication($eventDate, $startTime, $endTime)
    {
        return DB::table('events')
            ->whereDate('start_date', $eventDate)
            ->whereTime('end_date', '>', $startTime)
            ->whereTime('start_date', '<', $endTime)
            ->exists();
    }

    public static function countEventDuplication($eventDate, $startTime, $endTime)
    {
        return DB::table('events')
            ->whereDate('start_date', $eventDate)
            ->whereTime('end_date', '>', $startTime)
            ->whereTime('start_date', '<', $endTime)
            ->count();
    }

    public static function joinDateAndTime($date, $time)
    {
        $join = $date . " " . $time;
        return Carbon::createFromFormat('Y-m-d H:i', $join);
    }

    public static function getWeekEvents($startDate, $endDate)
    {
        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date')
        ->groupBy('event_id');

        return DB::table('events')
        ->leftJoinSub($reservedPeople, 'reservedPeople', function($join){
            $join->on('events.id', '=', 'reservedPeople.event_id');
        })
        ->where('events.is_visible', 1)
        ->whereBetween('start_date', [$startDate, $endDate])
        ->orderBy('start_date', 'asc')
        ->get();

    }

    public static function getUserReservedEvents($userId, $startDate, $endDate)
    {
        // ログインしていない場合は空のコレクションを返す
        if (is_null($userId)) {
            return collect();
        }

        return DB::table('reservations')
            ->join('events', 'reservations.event_id', '=', 'events.id')
            ->where('reservations.user_id', $userId)
            ->whereNull('reservations.canceled_date')
            ->whereBetween('events.start_date', [$startDate, $endDate])
            ->select('events.*')
            ->get();
    }

    // 有効なEventが存在するかチェック
    public function getEventExit($event)
    {
        // 論理削除されていないイベントのみ取得
        $event->deleted_at !== null;

        // $eventがnull でないかをチェック
        if(
            $filteredEvent = $event->filter(function($event){
                return $event->start_date !== null;
            })
        ){

        }

        return $filteredEvent;
    }

}
