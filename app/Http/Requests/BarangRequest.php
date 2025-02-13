<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'tgl_pembelian' => 'required|date',
            'tgl_kadaluarsa' => 'nullable|date|after_or_equal:tgl_pembelian',
            'harga_beli' => 'required',
            'harga_jual_1' => 'required',
            'harga_jual_2' => 'required',
            'harga_jual_3' => 'required',
            'stok' => 'required|numeric|min:1',
            'stok_minimal' => 'required|numeric|min:1',
            'kategori_id' => 'required|exists:kategoris,id',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'tgl_pembelian.required' => 'Tanggal pembelian wajib diisi.',
            'tgl_kadaluarsa.after_or_equal' => 'Tanggal expired harus lebih besar atau sama dengan tanggal pembelian.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_jual_1.required' => 'Harga Jual 1 wajib diisi.',
            'harga_jual_2.required' => 'Harga Jual 2 wajib diisi.',
            'harga_jual_3.required' => 'Harga Jual 3 wajib diisi.',
            'stok.required' => 'Stok barang wajib diisi.',
            'stok_minimal.required' => 'Minimal stok wajib diisi.',
            'kategori_id.required' => 'Kategori barang wajib dipilih.',
        ];
    }
}
