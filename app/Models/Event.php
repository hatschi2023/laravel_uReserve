<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Carbon\Carbon;
use App\Models\User;


class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'information',
        'max_people',
        'start_date',
        'end_date',
        'is_visible',
    ];

    protected function eventDate(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->start_date)->format('Y年m月d日')
        );
    }

    protected function editEventDate(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->start_date)->format('Y-m-d')
        );
    }

    protected function startTime(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->start_date)->format('H時-i分')
        );
    }
    protected function endTime(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->end_date)->format('H時-i分')
        );
    }

    // EventとUserの多対多リレーション
    public function users()
    {
        return $this->belongsToMany(User::class, 'reservations')
        ->withPivot(['id', 'number_of_people', 'canceled_date']);
    }

    // EventとReservationの1対多リレーション
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    //Event 削除時に関連する reservations を論理削除
    protected static function boot()
    {
        parent::boot();
        static::deleting(function($event){
            $event->reservations()->delete();//論理削除
        });
    }

}
