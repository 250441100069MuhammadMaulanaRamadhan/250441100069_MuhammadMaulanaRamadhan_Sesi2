<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePesananRequest;
use App\Http\Requests\UpdatePesananRequest;
use App\Models\Pesanan;
use App\Models\id;
use App\Models\menu;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $menu = Pesanan ::with(['meja_id', 'nama_pelanggan'])
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('nama_menu', 'like', '%' . $request->cari . '%')
                      ->orWhere('menu_id', 'like', '%' . $request->cari . '%');
                });
            })
            ->when($request->filled('pesanan'), fn ($q) => $q->where('menu_id', $request->kategori))
            ->when($request->boolean('tersedia'), fn ($q) => $q->tersedia())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pesanan.index', [
            'menu'   => $menu,
            'pesanan' => pesanan::orderBy('nama')->get(),
        ]);
    }

    public function create()
    {
        return view('barang.create', [
            'menu'   => new pesanan(),
            'pesanan' => pesanan::orderBy('nama')->get(),
        ]);
    }

    public function store(StorePesananRequest $request)
    {
        Menu::create($request->validated());

        return redirect()->route('menu.index')
            ->with('success', 'menu berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'lokasi']);

        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', [
            'barang'   => $barang,
            'kategori' => Kategori::orderBy('nama')->get(),
            'lokasi'   => Lokasi::orderBy('nama')->get(),
        ]);
    }

    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $barang->update($request->validated());

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}