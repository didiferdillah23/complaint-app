<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivasi extends Model
{
    protected $guarded = [];
    
    public function relatable()
    {
        return $this->morphTo();
    }
}
