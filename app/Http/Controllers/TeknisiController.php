<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasangan;

class TeknisiController extends Controller
{
    public function index()
    {
        $pemasangans = Pemasangan::where('status', '!=', 'Selesai')->get();
        return view('teknisi.dashboard', compact('pemasangans'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:proses,selesai',
            'catatan' => 'nullable|string|max:255',
        ]);
    
        $pemasangan = Pemasangan::findOrFail($id);
        $pemasangan->status = $request->status;
        $pemasangan->catatan = $request->catatan;
        $pemasangan->save();
    
        return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai',
        ]);

        $pemasangan = Pemasangan::findOrFail($id);
        $pemasangan->status = $request->status;
        $pemasangan->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
