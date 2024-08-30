<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AdminAuthController extends Controller
{
    public function adminLogin()
    {
        try {
            return view('backend.pages.login.admin_login');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function adminLoginRequest(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                if ($user->role === UserRole::ADMIN->value) {
                    return response()->json(['redirect_url' => route('adminDashboard')]);
                } else {
                    Auth::logout();
                    return response()->json(['error' => "You are not authorized to access this area."], 403);
                }
            }
            return response()->json(['error' => "Hmm, that didn’t work. Could you check your login info and try again?"], 422);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function adminLogout()
    {
        try {
            Auth::logout();
            return redirect()->route('adminLogin');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

}
