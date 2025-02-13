<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiskonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kode_diskon' => 'required|string|max:255|unique:diskons,kode_diskon,' . $this->route('id'),
            'nama_diskon' => 'required|string|max:255',
            'diskon' => 'required|numeric|min:0|max:100',
            'min_diskon' => 'required|min:0',
            'max_diskon' => 'required|min:0|gte:min_diskon',
            'type_pelanggan_id' => 'required|exists:type_pelanggans,id',
            'tgl_mulai' => 'required|date|date_format:Y-m-d',
            'tgl_berakhir' => 'required|date|date_format:Y-m-d|after:tgl_mulai',
        ];
    }

    public function messages()
    {
        return [
            'kode_diskon.required' => 'Kode diskon wajib diisi.',
            'kode_diskon.unique' => 'Kode sudah terdaftar.',
            'nama_diskon.required' => 'Nama diskon wajib diisi.',
            'diskon.required' => 'Diskon wajib diisi.',
            'diskon.numeric' => 'Diskon harus berupa angka.',
            'diskon.min' => 'Diskon tidak boleh kurang dari 0.',
            'diskon.max' => 'Diskon tidak boleh lebih dari 100.',
            'min_diskon.required' => 'Minimal diskon wajib diisi.',
            'min_diskon.min' => 'Minimal diskon tidak boleh kurang dari 0.',
            'max_diskon.required' => 'Maksimal diskon wajib diisi.',
            'max_diskon.min' => 'Maksimal diskon tidak boleh kurang dari 0.',
            'max_diskon.gte' => 'Maksimal diskon tidak boleh kurang dari minimal diskon.',
            'type_pelanggan_id.required' => 'Tipe pelanggan wajib dipilih.',
            'type_pelanggan_id.exists' => 'Tipe pelanggan tidak valid.',
            'tgl_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tgl_mulai.date' => 'Tanggal mulai tidak valid.',
            'tgl_mulai.date_format' => 'Format tanggal mulai tidak sesuai.',
            'tgl_berakhir.required' => 'Tanggal berakhir wajib diisi.',
            'tgl_berakhir.date' => 'Tanggal berakhir tidak valid.',
            'tgl_berakhir.date_format' => 'Format tanggal berakhir tidak sesuai.',
            'tgl_berakhir.after' => 'Tanggal berakhir harus setelah tanggal mulai.',
        ];
    }
}
