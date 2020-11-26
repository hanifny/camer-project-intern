<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class MeterRecord extends Model
{
    use Notifiable;
    use Uuid;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];
    public function validator() {
        return $this->belongsTo(User::class, 'validator_id');
    }
    public function engineer() {
        return $this->belongsTo(User::class, 'engineer_id');
    }
    public function unit() {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
