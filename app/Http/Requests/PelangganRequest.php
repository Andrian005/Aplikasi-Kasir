<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PelangganRequest extends FormRequest
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
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'required|numeric|digits_between:10,15',
            'jenis_kelamin' => 'required|in:L,P',
            'type_pelanggan_id' => 'required|exists:type_pelanggans,id',
            'poin_member' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
            'nomor_telepon.numeric' => 'Nomor telepon harus berupa angka.',
            'nomor_telepon.digits_between' => 'Nomor telepon harus antara 10 hingga 15 digit.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
            'type_pelanggan_id.required' => 'Type pelanggan wajib dipilih.',
            'type_pelanggan_id.exists' => 'Type pelanggan yang dipilih tidak valid.',
            'poin_member.required' => 'Poin Member harus di isi',
            'poin_member.numeric' => 'Poin Member harus berupa angka',
        ];
    }
}
