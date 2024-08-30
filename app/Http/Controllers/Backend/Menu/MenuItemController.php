<?php

namespace App\Http\Controllers\Backend\Menu;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class MenuItemController extends Controller
{
    public function menuItemIndex()
    {
        try {
            $menus = Menu::all();
            $menu_items = MenuItem::with('menu')->where('status', 1)->paginate(10);
            return view('backend.pages.menu-item.index', compact('menu_items', 'menus'));
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function menuItemStore(Request $request)
    {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'menu_id' => 'required',
                'item_name' => 'required',
                'quantity_per_person' => 'required',
                'in_grams' => 'nullable',
                'menu_assignment' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }
            $menu_item = new MenuItem();
            $menu_item->menu_id = $request->menu_id;
            $menu_item->item_name = $request->item_name;
            $menu_item->quantity_per_person = $request->quantity_per_person;
            $menu_item->in_grams = $request->in_grams ?? 1;
            $menu_item->menu_assignment = $request->menu_assignment;
            $menu_item->save();
            $menu_item->load('menu');
            return response()->json([
                'success' => 'Menu Item Added Successfully',
                'menu_item' => $menu_item
            ]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function menuItemEditContent(Request $request)
    {
        try {
            $id = $request->id;
            $menus = Menu::all();
            $menu_item = MenuItem::with('menu')->find($id);
            return view('backend.pages.menu-item.content', compact('menus', 'menu_item'));
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function menuItemUpdate(Request $request)
    {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:menu_items,id',
                'menu_id' => 'required|exists:menus,id',
                'item_name' => 'required',
                'quantity_per_person' => 'required',
                'in_grams' => 'nullable',
                'menu_assignment' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }
            $menu_item = MenuItem::find($request->id);
            $menu_item->menu_id = $request->menu_id;
            $menu_item->item_name = $request->item_name;
            $menu_item->quantity_per_person = $request->quantity_per_person;
            $menu_item->in_grams = $request->in_grams ?? 1;
            $menu_item->menu_assignment = $request->menu_assignment;
            $menu_item->save();
            $menu_item->load('menu');
            return response()->json([
                'success' => 'Menu Item Updated Successfully',
                'menu_item' => $menu_item
            ]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function menuItemDelete(Request $request){
        try {
            $id = $request->id;
            $menu_item = MenuItem::find($id);
            $menu_item->status = 0;
            $menu_item->save();
        
            $menu_item->load('menu');
            return response()->json([
                'success' => 'Menu Item Deleted successfully',
                'menu_item' => $menu_item
            ]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
        
    }

}
