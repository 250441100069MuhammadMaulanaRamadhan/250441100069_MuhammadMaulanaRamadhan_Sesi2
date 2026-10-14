<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePesananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_id'   => ['required', 'exists:kategoris,id'],
            'menu_id'     => ['required', 'exists:lokasis,id'],
            'nama_pelanggan'   => ['required', 'string', 'min:3', 'max:100'],
            'nomor_meja'          => ['required', 'integer', 'min:1'],
            'jumlah'       => ['required', 'in:baik,rusak,perbaikan'],
            'total_harga' => ['nullable', 'intenger', ],
        ];
    }

    public function messages(): array
    {
        return [
            'required'           => ':attribute wajib diisi.',
            'string'             => ':attribute harus berupa teks.',
            'integer'            => ':attribute harus berupa angka bulat.',
            'date'               => ':attribute harus berupa tanggal yang valid.',
            'menu_id.unique' => 'Kode barang :input sudah digunakan.',
            'nama_pesanan.min'    => 'Nama barang minimal :min karakter.',
            'stok.min'           => 'Stok tidak boleh negatif.',
            'kondisi.in'         => 'Kondisi harus baik, rusak, atau perbaikan.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'lokasi_id.exists'   => 'Lokasi yang dipilih tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kategori_id'   => 'kategori',
            'lokasi_id'     => 'lokasi',
            'kode_barang'   => 'kode barang',
            'nama_barang'   => 'nama barang',
            'stok'          => 'stok',
            'kondisi'       => 'kondisi',
            'tanggal_masuk' => 'tanggal masuk',
        ];
    }
}
