<?php

namespace App\Http\Controllers\Backend\Shift;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShiftWiseMenuController extends Controller
{
    public function shiftWiseMenuIndex()
    {
        try {
            return view('backend.pages.shift.shift-wise-menu-index');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
