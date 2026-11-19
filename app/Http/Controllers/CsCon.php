<?php

namespace App\Http\Controllers;

use App\Models\CsMessage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CsCon extends Controller
{
    /**
     * Halaman Customer Service — bisa diakses pengunjung (guest) maupun user login.
     */
    public function index(): View
    {
        // Kalau sudah login, nama & email otomatis terisi di form
        $user = auth()->user();

        return view('cs', [
            'defaultNama'  => $user?->name ?? old('nama'),
            'defaultEmail' => $user?->email ?? old('email'),
        ]);
    }

    /**
     * Simpan pesan dari form kontak CS ke tabel cs_messages.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'         => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:150'],
            'whatsapp'     => ['nullable', 'string', 'max:20'],
            'subjek'       => ['nullable', 'in:Pertanyaan Produk,Status Pesanan,Komplain/Kerusakan,Saran,Lainnya'],
            'id_pembelian' => ['nullable', 'string', 'max:50'],
            'pesan'        => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'pesan.min' => 'Pesan terlalu pendek, tuliskan minimal 10 karakter.',
        ]);

        CsMessage::create([
            'nama'         => $validated['nama'],
            'email'        => $validated['email'],
            'whatsapp'     => $validated['whatsapp'] ?? null,
            'subjek'       => $validated['subjek'] ?? 'Lainnya',
            'id_pembelian' => $validated['id_pembelian'] ?? null,
            'pesan'        => $validated['pesan'],
            'user_id'      => auth()->id(), // null kalau pengunjung belum login
            'status'       => 'Baru',
        ]);

        return back()->with(
            'success',
            'Pesan Anda terkirim! Tim CS kami akan membalas melalui email/WA dalam 1x24 jam.'
        );
    }
}
