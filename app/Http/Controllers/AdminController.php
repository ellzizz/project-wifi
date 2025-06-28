<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasangan;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $pemasangans = Pemasangan::with('user')->latest()->get();
        $users = User::where('role', '!=', 'admin')->get(); // Tambahkan ini

        return view('admin.dashboard', compact('pemasangans', 'users')); // Kirim juga $users
    }

    public function updateKeterangan(Request $request, $id)
    {
        $request->validate(['keterangan_admin' => 'nullable|string|max:255']);

        $pemasangan = Pemasangan::findOrFail($id);
        $pemasangan->keterangan_admin = $request->keterangan_admin;
        $pemasangan->save();

        return redirect()->back()->with('success', 'Keterangan admin diperbarui.');
    }
}
