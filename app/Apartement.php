<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartement extends Model
{
    public function type() {
        return $this->belongsTo('App\Type', 'type_id', 'type');
    }
}
