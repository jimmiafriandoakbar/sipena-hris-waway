<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function updatePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    $user = auth()->user();

    if (!\Hash::check($request->old_password, $user->password)) {
        return back()->withErrors(['Password lama salah']);
    }

    $user->update([
        'password' => \Hash::make($request->new_password)
    ]);

    return back()->with('success', 'Password admin berhasil diubah');
}
}
