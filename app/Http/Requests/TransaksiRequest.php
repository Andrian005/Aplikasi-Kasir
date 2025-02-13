<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransaksiRequest extends FormRequest
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
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
            'diskon' => 'required|numeric|min:0',
            'detail_transaksi' => 'required|array|min:1',
            'detail_transaksi.*.barang_id' => 'required|exists:barangs,id',
            'detail_transaksi.*.jumlah' => 'required|integer|min:1',
            'detail_transaksi.*.harga_satuan' => 'required|numeric|min:0',
            'detail_transaksi.*.sub_total' => 'required|numeric|min:0',

            'total_harga' => 'required|numeric|min:0',
            'ppn' => 'required|numeric|min:0',
            'total_final' => 'required|numeric|min:0',
            'poin_didapat' => 'required|numeric|min:0',
            'poin_digunakan' => 'required|numeric|min:0',
            'pembayaran' => 'required|numeric|min:0',
            'kembalian' => 'required|numeric|min:0',
        ];
    }
}
