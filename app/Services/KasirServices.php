<?php

namespace App\Services;

use App\Repository\BarangRepository;
use App\Repository\PelangganRepository;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repository\KasirRepository;

class KasirServices
{
    protected $kasirRepository;
    protected $barangRepository;
    protected $pelangganRepository;

    public function __construct(KasirRepository $kasirRepository, BarangRepository $barangRepository, PelangganRepository $pelangganRepository)
    {
        $this->kasirRepository = $kasirRepository;
        $this->barangRepository = $barangRepository;
        $this->pelangganRepository = $pelangganRepository;
    }

    public function getDiskon($type_pelanggan)
    {
        return $this->kasirRepository->getDiskon($type_pelanggan);
    }

    public function getBarang()
    {
        return $this->kasirRepository->getBarang();
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {

            $transaksi = [
                'invoice' => 'INV-' . Carbon::now()->format('YmdHis'),
                'kasir_id' => Auth::user()->id,
                'pelanggan_id' => $data['pelanggan_id'],
                'total_belanja' => $data['total_harga'],
                'diskon' => $data['diskon'],
                'ppn' => $data['ppn'],
                'total_akhir' => $data['total_final'],
                'poin_member_didapat' => $data['poin_didapat'],
                'poin_member_digunakan' => $data['poin_digunakan'],
                'pembayaran' => $data['pembayaran'],
                'kembalian' => $data['kembalian'],
                'created_at' => Carbon::now(),
                'created_by' => Auth::user()->name,
            ];

            if (!empty($data['pelanggan_id'])) {
                $pelanggan = $this->pelangganRepository->findById($data['pelanggan_id']);

                if (!empty($data['poin_digunakan'])) {
                    $pelanggan->poin_member = $pelanggan->poin_member - $data['poin_digunakan'] + $data['poin_didapat'];
                } else {
                    $pelanggan->poin_member = $pelanggan->poin_member + $data['poin_didapat'];
                }

                $this->pelangganRepository->update($data['pelanggan_id'], ['poin_member' => $pelanggan->poin_member]);
            }

            $transaksiId = $this->kasirRepository->storeTransaksi($transaksi);

            if (isset($data['detail_transaksi']) && is_array($data['detail_transaksi'])) {
                foreach ($data['detail_transaksi'] as $detail) {
                    $barang = $this->barangRepository->findById($detail['barang_id']);
                    $jumlahBarang = $detail['jumlah'];

                    $stokList = $barang->tambahStok()
                        ->where('jumlah_stok', '>', 0)
                        ->where('tgl_kadaluarsa', '>=', now())
                        ->orderBy('tgl_kadaluarsa')
                        ->get();

                    foreach ($stokList as $stok) {
                        if ($jumlahBarang <= 0)
                            break;
                        $kurang = min($jumlahBarang, $stok->jumlah_stok);
                        $stok->decrement('jumlah_stok', $kurang);
                        $jumlahBarang -= $kurang;
                    }

                    if ($jumlahBarang > 0 && $barang->tgl_kadaluarsa >= now()) {
                        $barang->decrement('stok', $jumlahBarang);
                    }

                    $this->kasirRepository->storeDetailTransaksi([
                        'transaksi_id' => $transaksiId->id,
                        'barang_id' => $detail['barang_id'],
                        'jumlah_barang' => $detail['jumlah'],
                        'harga_satuan' => $detail['harga_satuan'],
                        'sub_total' => $detail['sub_total'],
                        'created_by' => Auth::user()->name,
                    ]);
                }
            }

            DB::commit();
            return [
                'message' => 'Transaksi Berhasil di Tambah',
                'success' => true,
                'status' => 200,
                'transaksiId' => $transaksiId->id,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => 'Transaksi Gagal di Tambah',
                'errors' => $e->getMessage(),
                'status' => $e->getCode(),
                'success' => false,
            ];
        }
    }

    public function invoice($transaksiId)
    {
        return $this->kasirRepository->invoice($transaksiId);
    }
}
