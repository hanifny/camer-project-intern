<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Apartement extends Model
{
    use Notifiable;
    use Uuid;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];
    public function type() {
        return $this->belongsTo(Type::class);
    }
}
