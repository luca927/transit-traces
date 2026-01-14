<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    public function person() { return $this->belongsTo(Person::class); }
    public function place() { return $this->belongsTo(Place::class); }
    public function media() { return $this->morphMany(Media::class, 'mediable'); }
}
