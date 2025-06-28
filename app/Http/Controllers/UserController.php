<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasangan;

class UserController extends Controller
{
    public function index()
    {
        $pemasangans = Pemasangan::where('user_id', auth()->id())->get();
        return view('user.dashboard', compact('pemasangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|max:255',
        ]);

        Pemasangan::create([
            'user_id' => auth()->id(),
            'alamat' => $request->alamat,
            'status' => 'Menunggu',
        ]);

        return redirect()->back()->with('success', 'Pengajuan berhasil dikirim.');
    }
}
