<?php

namespace App\Http\Controllers\Backend\ManPower;

use App\Http\Controllers\Controller;
use App\Models\Manpower;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ManPowerController extends Controller
{
    public function manpowerIndex()
    {
        try {

            $shifts = Shift::all();
            $manpowers = Manpower::where('status', 1)->with('shift')->latest()->paginate(10);
            return view('backend.pages.manpower.index', compact('manpowers', 'shifts'));
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function manpowerStore(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'shift_id' => 'required|exists:shifts,id',
                'count' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }

            $existingRecord = Manpower::where('shift_id', $request->shift_id)
                ->whereDate('date', now()->toDateString())
                ->first();

            if ($existingRecord) {
                return response()->json(['error' => 'Manpower record for this shift already exists for today. You can just update the value today'], 422);
            }

            $manpower = new Manpower();
            $manpower->shift_id = $request->shift_id;
            $manpower->count = $request->count;
            $manpower->date = now();
            $manpower->save();

            $manpower->load('shift');
            return response()->json([
                'success' => 'Manpower Added Successfully',
                'manpower' => $manpower
            ]);
        }catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function manpowerEditContent(Request $request)
    {
        try {
            $id = $request->id;
            $shifts = Shift::all();
            $manpower = Manpower::with('shift')->find($id);
            return view('backend.pages.manpower.content', compact('manpower', 'shifts'));
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function manpowerUpdate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:manpower,id',
                'shift_id' => 'required|exists:shifts,id',
                'count' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }
            $manpower = Manpower::find($request->id);
            $manpower->shift_id = $request->shift_id;
            $manpower->count = $request->count;
            $manpower->date = now();
            $manpower->save();
            $manpower->load('shift');
            return response()->json([
                'success' => 'Manpower Updated Successfully',
                'manpower' => $manpower
            ]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function manpowerDelete(Request $request){
        try {
            $id = $request->id;
            $manpower = Manpower::find($id);
            $manpower->status = 0;
            $manpower->save();

            $manpower->load('shift');
            return response()->json([
                'success' => 'Manpower Deleted successfully',
                'manpower' => $manpower
            ]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }
}
