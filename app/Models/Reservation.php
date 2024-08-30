<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Reservation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'event_id',
        'number_of_people',
    ];

    //追加（ログインユーザーイベント取得処理で）
    // ReservationとUserの多対1リレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ReservationとEventの多対1リレーション
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
