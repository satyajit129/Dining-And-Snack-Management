<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manpower extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'manpower';
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
