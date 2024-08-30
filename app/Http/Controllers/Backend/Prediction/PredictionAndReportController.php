<?php

namespace App\Http\Controllers\Backend\Prediction;

use App\Http\Controllers\Controller;
use App\Models\Manpower;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PredictionAndReportController extends Controller
{
    public function predictionReportIndex()
    {
        try {
            $snacksPrediction = $this->predictSnacks();
            $lunchPrediction = $this->predictLunch();
            $itemQtyCalculation = $this->calculateItemQty();
            $data = [
                'snacksPrediction' => $snacksPrediction,
                'lunchPrediction' => $lunchPrediction,
                'itemQtyCalculation' => $itemQtyCalculation,
            ];

            // Pass data to the view
            return view('backend.pages.prediction.index', compact('data'));
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    protected function predictSnacks()
    {
        $today = now()->format('Y-m-d');
        $manpowerToday = Manpower::where('date', $today)->get();

        // Calculate snack predictions for today
        $morningSnacksQty = ($manpowerToday->whereIn('shift_id', [1, 2])->sum('count')) * 2; // Example: 2 snacks per person
        $afternoonSnacksQty = ($manpowerToday->whereIn('shift_id', [3, 4])->sum('count')) * 1; // Example: 1 snack per person

        // Predict for tomorrow based on average manpower
        $averageManpower = Manpower::select('shift_id', DB::raw('AVG(count) as avg_count'))
            ->groupBy('shift_id')
            ->get();
        $tomorrowMorningSnacksQty = ($averageManpower->whereIn('shift_id', [1, 2])->sum('avg_count')) * 2;
        $tomorrowAfternoonSnacksQty = ($averageManpower->whereIn('shift_id', [3, 4])->sum('avg_count')) * 1;

        return [
            'today' => [
                'morning' => $morningSnacksQty,
                'afternoon' => $afternoonSnacksQty,
            ],
            'tomorrow' => [
                'morning' => $tomorrowMorningSnacksQty,
                'afternoon' => $tomorrowAfternoonSnacksQty,
            ],
        ];
    }
    protected function predictLunch()
    {
        $today = now()->format('Y-m-d');
        $manpowerToday = Manpower::where('date', $today)->get();

        // Calculate lunch predictions for today
        $lunchQty = ($manpowerToday->whereIn('shift_id', [1, 2, 3])->sum('count')) * 150; // Example: 150g of food per person

        // Predict for tomorrow based on average manpower
        $averageManpower = Manpower::select('shift_id', DB::raw('AVG(count) as avg_count'))
            ->groupBy('shift_id')
            ->get();
        $tomorrowLunchQty = ($averageManpower->whereIn('shift_id', [1, 2, 3])->sum('avg_count')) * 150;

        return [
            'today' => $lunchQty,
            'tomorrow' => $tomorrowLunchQty,
        ];
    }
    protected function calculateItemQty()
    {
        
        $snackItems = [
            'banana' => ['morning' => 2, 'afternoon' => 1], // Example: 2 pieces per person in the morning, 1 in the afternoon
            'biscuit' => ['morning' => 1, 'afternoon' => 1], // Example: 1 piece per person in both sessions
        ];

        $lunchItems = [
            'beef' => ['today' => 150, 'tomorrow' => 150], // Example: 150g per person
            'rice' => ['today' => 120, 'tomorrow' => 120], // Example: 120g per person
        ];

        return [
            'snacks' => $snackItems,
            'lunch' => $lunchItems,
        ];
    }

}
