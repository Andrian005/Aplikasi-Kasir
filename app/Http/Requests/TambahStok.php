<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TambahStok extends FormRequest
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
            'jumlah_stok' => 'required|numeric|min:1',
            'tgl_pembelian' => 'required|date',
            'tgl_kadaluarsa' => 'required|date|after_or_equal:tgl_pembelian',

        ];
    }

    public function messages(): array
    {
        return [
            'jumlah_stok.required' => 'Jumlah Stok barang wajib diisi.',
            'tgl_pembelian.required' => 'Tanggal pembelian wajib diisi.',
            'tgl_kadaluarsa.required' => 'Tanggal kadaluarsa wajib diisi.',
            'tgl_kadaluarsa.after_or_equal' => 'Tanggal expired harus lebih besar atau sama dengan tanggal pembelian.',
        ];
    }
}
