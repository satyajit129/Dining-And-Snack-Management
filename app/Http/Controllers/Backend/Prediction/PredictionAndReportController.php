<?php

namespace App\Http\Controllers\Backend\Prediction;

use App\Enums\ShiftEnum;
use App\Http\Controllers\Controller;
use App\Models\Manpower;
use App\Models\MenuItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PredictionAndReportController extends Controller
{

    public function predictionReportIndex()
    {
        try {
            // Data excluding today's date (for today's prediction)
            $manpowerForTodayPrediction = Manpower::where('date', '<', now()->format('Y-m-d'))->get();
    
            // Data including today's date (for next day's prediction)
            $manpowerForNextDayPrediction = Manpower::all();
    
            // Calculate averages for today's prediction
            $averageMorningSnacksToday = $this->calculateAverageSnacksMorning($manpowerForTodayPrediction);
            $averageAfternoonSnacksToday = $this->calculateAverageSnacksAfternoon($manpowerForTodayPrediction);
            $averageLunchToday = $this->calculateAverageLunch($manpowerForTodayPrediction);
    
            // Calculate averages for next day's prediction
            $averageMorningSnacksNextDay = $this->calculateAverageSnacksMorning($manpowerForNextDayPrediction);
            $averageAfternoonSnacksNextDay = $this->calculateAverageSnacksAfternoon($manpowerForNextDayPrediction);
            $averageLunchNextDay = $this->calculateAverageLunch($manpowerForNextDayPrediction);
    
            // Predicted values
            $predictedMorningSnacksToday = $averageMorningSnacksToday;
            $predictedAfternoonSnacksToday = $averageAfternoonSnacksToday;
            $predictedLunchToday = $averageLunchToday;
    
            $predictedMorningSnacksNextDay = $averageMorningSnacksNextDay;
            $predictedAfternoonSnacksNextDay = $averageAfternoonSnacksNextDay;
            $predictedLunchNextDay = $averageLunchNextDay;
    
            // Calculate item quantities
            $predictedSnackItemsMorningToday = $this->calculateSnackItems($predictedMorningSnacksToday);
            $predictedSnackItemsAfternoonToday = $this->calculateSnackItems($predictedAfternoonSnacksToday);
            $predictedLunchItemsToday = $this->calculateLunchItems($predictedLunchToday);
    
            $predictedSnackItemsMorningNextDay = $this->calculateSnackItems($predictedMorningSnacksNextDay);
            $predictedSnackItemsAfternoonNextDay = $this->calculateSnackItems($predictedAfternoonSnacksNextDay);
            $predictedLunchItemsNextDay = $this->calculateLunchItems($predictedLunchNextDay);
    
            // Pass all calculated data to the view
            return view('backend.pages.prediction.index', compact(
                'averageMorningSnacksToday', 'averageAfternoonSnacksToday', 'predictedMorningSnacksToday', 'predictedAfternoonSnacksToday',
                'predictedSnackItemsMorningToday', 'predictedSnackItemsAfternoonToday', 'averageLunchToday', 'predictedLunchItemsToday', 'predictedLunchToday',
                'averageMorningSnacksNextDay', 'averageAfternoonSnacksNextDay', 'predictedMorningSnacksNextDay', 'predictedAfternoonSnacksNextDay',
                'predictedSnackItemsMorningNextDay', 'predictedSnackItemsAfternoonNextDay', 'averageLunchNextDay', 'predictedLunchItemsNextDay', 'predictedLunchNextDay'
            ));
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    private function calculateAverageSnacksMorning($manpower)
    {
        $totalMorningManpower = $manpower->whereIn('shift_id', [
            ShiftEnum::SHIFT_A->value,
            ShiftEnum::GENERAL_SHIFT->value
        ])->sum('count');

        $distinctDates = $manpower->unique('date')->count();

        return $distinctDates ? $totalMorningManpower / $distinctDates : 0;
    }
    private function calculateAverageSnacksAfternoon($manpower)
    {
        $totalAfternoonManpower = $manpower->whereIn('shift_id', [
            ShiftEnum::SHIFT_B->value,
            ShiftEnum::SHIFT_C->value
        ])->sum('count');

        $distinctDates = $manpower->unique('date')->count();

        return $distinctDates ? $totalAfternoonManpower / $distinctDates : 0;
    }
    private function calculateAverageLunch($manpower)
    {
        $totalLunchManpower = $manpower->whereIn('shift_id', [
            ShiftEnum::SHIFT_A->value,
            ShiftEnum::GENERAL_SHIFT->value,
            ShiftEnum::SHIFT_B->value
        ])->sum('count');
        $distinctDates = $manpower->unique('date')->count();
        return $distinctDates ? $totalLunchManpower / $distinctDates : 0;
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
    private function calculateLunch($manpower)
    {
        return $manpower->whereIn('shift_id', [
            ShiftEnum::SHIFT_A->value,
            ShiftEnum::GENERAL_SHIFT->value,
            ShiftEnum::SHIFT_B->value
        ])->sum('count');
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
