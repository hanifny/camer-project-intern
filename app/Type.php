<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Type extends Model
{
    use Notifiable;
    use Uuid;
    protected $keyType = 'string';
    public $incrementing = false;

    public function unit() {
        return $this->hasMany(Apartement::class);
    }
}
