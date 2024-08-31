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
            $snacksMorning_array = $this->calculateSnacksMorning($manpower);
            // dd($snacksMorning_array);
            $snacksAfternoon_array = $this->calculateSnacksAfternoon($manpower);
            $lunch_array = $this->calculateLunch($manpower);


            $snacksMorning = $snacksMorning_array['count'];
            $snacksAfternoon = $snacksAfternoon_array['count'];
            $lunch = $lunch_array['count'];

            // Calculate snack item quantities
            $snackItemsMorning = $this->calculateSnackItems($snacksMorning);
            $snackItemsAfternoon = $this->calculateSnackItems($snacksAfternoon);
            $lunchItems = $this->calculateLunchItems($lunch);

            return view('backend.pages.dashboard.admin_dashboard', compact('snacksMorning_array', 'snacksAfternoon_array', 'lunch_array', 'weekday_name', 'snackItemsMorning', 'snackItemsAfternoon', 'lunchItems'));
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    private function calculateSnacksMorning($manpower)
    {
        $shiftA = ShiftEnum::SHIFT_A->value;
        $generalShift = ShiftEnum::GENERAL_SHIFT->value;
        $shiftACount = $manpower->where('shift_id', $shiftA)->sum('count');
        $generalShiftCount = $manpower->where('shift_id', $generalShift)->sum('count');
        $totalCount = $shiftACount + $generalShiftCount;
        return [
            'shiftA' => 'shiftA - ' . $shiftACount,
            'generalShift' => 'generalShift - ' . $generalShiftCount,
            'count' => $totalCount
        ];
    }

    private function calculateSnacksAfternoon($manpower)
    {
        $shiftB = ShiftEnum::SHIFT_B->value;
        $shiftC = ShiftEnum::SHIFT_C->value;
        $shiftBCount = $manpower->where('shift_id', $shiftB)->sum('count');
        $shiftCCount = $manpower->where('shift_id', $shiftC)->sum('count');
        $totalCount = $shiftBCount + $shiftCCount;
        return [
            'shiftB' => 'shiftB - ' . $shiftBCount,
            'shiftC' => 'shiftC - ' . $shiftCCount,
            'count' => $totalCount
        ];
    }


    private function calculateLunch($manpower)
    {
        $shiftA = ShiftEnum::SHIFT_A->value;
        $generalShift = ShiftEnum::GENERAL_SHIFT->value;
        $shiftB = ShiftEnum::SHIFT_B->value;
        $shiftACount = $manpower->where('shift_id', $shiftA)->sum('count');
        $generalShiftCount = $manpower->where('shift_id', $generalShift)->sum('count');
        $shiftBCount = $manpower->where('shift_id', $shiftB)->sum('count');

        $totalCount = $shiftACount + $generalShiftCount + $shiftBCount;
        return [
            'shiftA' => 'shiftA - ' . $shiftACount,
            'generalShift' => 'generalShift - ' . $generalShiftCount,
            'shiftB' => 'shiftB - ' . $shiftBCount,
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
