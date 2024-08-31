<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftWiseMenu extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
