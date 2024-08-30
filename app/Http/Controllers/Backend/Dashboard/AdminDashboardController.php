<?php

namespace App\Http\Controllers\Backend\Dashboard;

use App\Enums\ShiftEnum;
use App\Http\Controllers\Controller;
use App\Models\Manpower;
use App\Models\MenuItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

class AdminDashboardController extends Controller
{
    public function adminDashboard()
    {
        try {
            $today_date = Carbon::now()->format('Y-m-d');
            $weekday_name = Carbon::now()->format('l');
            $manpower = Manpower::whereDate('date', $today_date)->get();
            $snacksMorning = $this->calculateSnacksMorning($manpower);
            // dd($snacksMorning);
            $snacksAfternoon = $this->calculateSnacksAfternoon($manpower);
            $lunch = $this->calculateLunch($manpower);

            // Calculate snack item quantities
            $snackItemsMorning = $this->calculateSnackItems($snacksMorning);
            $snackItemsAfternoon = $this->calculateSnackItems($snacksAfternoon);
            $lunchItems = $this->calculateLunchItems($lunch);

            return view('backend.pages.dashboard.admin_dashboard', compact('snacksMorning', 'snacksAfternoon', 'lunch', 'weekday_name', 'snackItemsMorning', 'snackItemsAfternoon','lunchItems'));
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    private function calculateSnacksMorning($manpower)
    {
        return $manpower->whereIn('shift_id', [
            ShiftEnum::SHIFT_A->value,
            ShiftEnum::GENERAL_SHIFT->value
        ])->sum('count');
    }

    private function calculateSnacksAfternoon($manpower)
    {
        return $manpower->whereIn('shift_id', [
            ShiftEnum::SHIFT_B->value,
            ShiftEnum::SHIFT_C->value
        ])->sum('count');
    }

    private function calculateLunch($manpower)
    {
        return $manpower->whereIn('shift_id', [
            ShiftEnum::SHIFT_A->value,
            ShiftEnum::GENERAL_SHIFT->value,
            ShiftEnum::SHIFT_B->value
        ])->sum('count');
    }
    private function calculateSnackItems($manpowerCount)
    {
        $snackItems = MenuItem::where('menu_id', 1)->get();
        $calculatedItems = [];

        foreach ($snackItems as $item) {
            $calculatedItems[$item->item_name] = $manpowerCount * $item->quantity_per_person;
        }

        return $calculatedItems;
    }
    private function calculateLunchItems($manpowerCount)
    {
        $lunchItems = MenuItem::where('menu_id', 2)->get();
        $calculatedItems = [];

        foreach ($lunchItems as $item) {
            $calculatedItems[$item->item_name] = $manpowerCount * $item->quantity_per_person;
        }

        return $calculatedItems;
    }
}
