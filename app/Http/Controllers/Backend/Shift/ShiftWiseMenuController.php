<?php

namespace App\Http\Controllers\Backend\Shift;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Shift;
use App\Models\ShiftWiseMenu;
use Illuminate\Http\Request;
use Throwable;

class ShiftWiseMenuController extends Controller
{
    public function shiftWiseMenuIndex()
    {
        try {
            $shift_wise_menus = ShiftWiseMenu::with('shift', 'menu')->get();
            $shifts = Shift::all();
            $menus = Menu::all();
            return view('backend.pages.shift.shift-wise-menu-index', compact('shifts', 'menus', 'shift_wise_menus'));
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function shiftWiseMenuCreate()
    {
        try {
            $shifts = Shift::all();
            $menus = Menu::all();
            return view('backend.pages.shift.shift-wise-menu-create', compact('shifts', 'menus'));
        } catch (Throwable $th) {
            return response()->back()->with('error', $th->getMessage());
        }

    }
    public function shiftWiseMenuStore(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'shift_id' => 'required|array',
                'shift_id.*' => 'exists:shifts,id',
                'menu_id' => 'required|in:1,2',
                'time_of_day' => 'nullable|required_if:menu_id,1|in:morning,afternoon',
            ]);


            foreach ($validatedData['shift_id'] as $shiftId) {
                $query = ShiftWiseMenu::where('shift_id', $shiftId)
                    ->where('menu_id', $validatedData['menu_id']);

                if ($validatedData['menu_id'] == 1) {
                    $query->where('time_of_day', $validatedData['time_of_day']);
                }

                $exists = $query->exists();

                if (!$exists) {
                    ShiftWiseMenu::create([
                        'shift_id' => $shiftId,
                        'menu_id' => $validatedData['menu_id'],
                        'time_of_day' => $validatedData['menu_id'] == 1 ? $validatedData['time_of_day'] : null,
                    ]);
                } else {
                    return response()->json(['error' => 'This Data already exists'], 500);
                }
            }
            return response()->json([
                'success' => 'Shift-wise menu created successfully.',
                'redirect' => route('shiftWiseMenuIndex')
            ]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function shiftWiseMenuEditContent($id)
    {
        try {
            $shiftWiseMenu = ShiftWiseMenu::findOrFail($id);
            $menus = Menu::all();
            $shifts = Shift::all();
            $selectedShifts = $shiftWiseMenu->shift()->pluck('id')->toArray();

            return view('backend.pages.shift.shift-wise-menu-edit', compact('shiftWiseMenu', 'menus', 'shifts', 'selectedShifts'));
        } catch (Throwable $th) {
            //throw $th;
        }
    }
    public function shiftWiseMenuUpdate(Request $request, $id)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'shift_id' => 'required|exists:shifts,id',
                'menu_id' => 'required|in:1,2',
                'time_of_day' => 'nullable|required_if:menu_id,1|in:morning,afternoon',
            ]);
        
            // Find the ShiftWiseMenu record by ID
            $shiftWiseMenu = ShiftWiseMenu::findOrFail($id);
        
            // Prepare a query to check if the updated record already exists
            $query = ShiftWiseMenu::where('shift_id', $validatedData['shift_id'])
                ->where('menu_id', $validatedData['menu_id']);
        
            // If the menu type is 'snacks' (menu_id == 1), add time_of_day condition to the query
            if ($validatedData['menu_id'] == 1) {
                $query->where('time_of_day', $validatedData['time_of_day'] ?? null);
            }
        
            // Check if a record with the same data already exists
            $exists = $query->exists();
        
            if (!$exists) {
                // If no such record exists, update the current record
                $shiftWiseMenu->update($validatedData);
            } else {
                // If the record already exists, return an error response
                return response()->json(['error' => 'This Data already exists'], 500);
            }
        
            // Return a success response with a redirect URL
            return response()->json([
                'success' => 'Shift-wise menu updated successfully.',
                'redirect' => route('shiftWiseMenuIndex')
            ]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function shiftWiseMenuDelete($id)
    {
        try {
            $shiftWiseMenu = ShiftWiseMenu::findOrFail($id);
            $shiftWiseMenu->delete();
            return redirect()->back()->with('success', 'Shift-wise menu deleted successfully.');
        } catch (Throwable $th) {
            return redirect()->back()->with('error' , $th->getMessage());
        }
    }
}
