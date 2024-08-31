<?php

namespace App\Http\Controllers\Backend\Dashboard;

use App\Enums\ShiftEnum;
use App\Http\Controllers\Controller;
use App\Models\Manpower;
use App\Models\MenuItem;
use App\Models\Shift;
use App\Models\ShiftWiseMenu;
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
            $manpower = Manpower::whereDate('date', $today_date)->where('status', 1)->get();
            $shiftWiseMenus = ShiftWiseMenu::all();
            $snacksMorning_array = $this->calculateSnacks($manpower, $shiftWiseMenus, 'morning');
            $snacksAfternoon_array = $this->calculateSnacks($manpower, $shiftWiseMenus, 'afternoon');
            $lunch_array = $this->calculateLunch($manpower, $shiftWiseMenus);
            $snackItemsMorning = $this->calculateSnackItems($snacksMorning_array['count']);
            $snackItemsAfternoon = $this->calculateSnackItems($snacksAfternoon_array['count']);
            $lunchItems = $this->calculateLunchItems($lunch_array['count']);

            return view('backend.pages.dashboard.admin_dashboard', compact(
                'snacksMorning_array',
                'snacksAfternoon_array',
                'lunch_array',
                'weekday_name',
                'snackItemsMorning',
                'snackItemsAfternoon',
                'lunchItems'
            ));
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    private function calculateSnacks($manpower, $shiftWiseMenus, $timeOfDay)
    {
        $shiftIds = $shiftWiseMenus->where('time_of_day', $timeOfDay)->pluck('shift_id');
        $totalCount = $manpower->whereIn('shift_id', $shiftIds)->sum('count');

        $shiftCounts = [];
        foreach ($shiftIds as $shiftId) {
            $shiftCounts[$shiftId] = $manpower->where('shift_id', $shiftId)->sum('count');
        }
        $shiftNames = [];
        foreach ($shiftCounts as $shiftId => $count) {
            $shift = Shift::find($shiftId);
            $shiftNames[] = "{$shift->name} - $count";
        }

        return [
            'shifts' => implode(', ', $shiftNames),
            'count' => $totalCount
        ];
    }

    private function calculateLunch($manpower, $shiftWiseMenus)
    {
        $shiftIds = $shiftWiseMenus->whereIn('menu_id', [2])
            ->pluck('shift_id');
        $totalCount = $manpower->whereIn('shift_id', $shiftIds)->sum('count');

        $shiftCounts = [];
        foreach ($shiftIds as $shiftId) {
            $shiftCounts[$shiftId] = $manpower->where('shift_id', $shiftId)->sum('count');
        }
        $shiftNames = [];
        foreach ($shiftCounts as $shiftId => $count) {
            $shift = Shift::find($shiftId);
            $shiftNames[] = "{$shift->name} - $count";
        }

        return [
            'shifts' => implode(', ', $shiftNames),
            'count' => $totalCount
        ];
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
