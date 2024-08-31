<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }
    public function menuAssignments()
    {
        return $this->hasMany(MenuAssignment::class);
    }
    public function shiftWiseMenus()
    {
        return $this->hasMany(ShiftWiseMenu::class);
    }
}
