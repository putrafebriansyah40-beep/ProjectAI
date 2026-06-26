<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bug;

class HistoryController extends Controller
{
    /**
     * Menampilkan riwayat simulasi yang telah tersimpan di database
     */
    public function index()
    {
        // 1. Mengambil seluruh riwayat dari tabel bugs
        // 2. Mengurutkan berdasarkan data terbaru (descending)
        $histories = Bug::latest()->get();

        // Hitung statistik (berdasarkan hasil Mamdani sebagai baseline)
        $stats = [
            'total' => $histories->count(),
            'low' => $histories->where('mamdani_label', 'Low')->count(),
            'medium' => $histories->where('mamdani_label', 'Medium')->count(),
            'high' => $histories->where('mamdani_label', 'High')->count(),
            'critical' => $histories->where('mamdani_label', 'Critical')->count(),
        ];

        // 3. Mengirimkan data 'histories' dan 'stats' ke tampilan history
        return view('history', compact('histories', 'stats'));
    }

    /**
     * Menghapus satu riwayat (record) dari tabel bugs
     */
    public function destroy(int $id)
    {
        $history = Bug::findOrFail($id);
        $history->delete();

        return redirect()->route('history')->with('success', 'Riwayat berhasil dihapus.');
    }
}

