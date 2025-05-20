<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\peminjamanBukuModel;
use App\Models\detailPeminjamanBukuModel;
use App\Models\pengembalianBukuModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class Transaksicontroller extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login', 'register']]);
    // }
    
    public function pinjamBuku(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id_siswa' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required'
        ]);
        if ($validator->fails()) { 
            return response()->json($validator->errors());
        }
        $save = peminjamanBukuModel::create([
            'id_siswa' => $req->id_siswa,
            'tanggal_pinjam' => $req->tanggal_pinjam,
            'tanggal_kembali' => $req->tanggal_kembali
        ]);

        if ($save) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    
    }

    //tambah item -> post
    public function tambahitem(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            // 'id_peminjaman_buku'=> 'required',
            'id_buku' => 'required',
            'qty' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $save = detailPeminjamanBukuModel::create([
            'id_peminjaman_buku' => $id,
            'id_buku' => $req->id_buku,
            'qty' => $req->qty
        ]);
        if ($save) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function PengembalianBuku(Request $req)
    {
    

    $validator = Validator::make($req->all(), [
        'id_peminjaman_buku' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors());
    }

    // Periksa apakah buku sudah dikembalikan
    $cek_kembali = pengembalianBukuModel::
        where('id_peminjaman_buku', $req->id_peminjaman_buku);

    // Dapatkan data peminjaman jika buku belum dikembalikan
    $dt_kembali = peminjamanBukuModel::
        where('id_peminjaman_buku', $req->id_peminjaman_buku)->first();

    if ($dt_kembali !== null) {

        // Hitung tanggal pengembalian dan denda keterlambatan
        $tanggal_sekarang = Carbon::now()->format('Y-m-d');
        $tanggal_kembali = new Carbon($dt_kembali->tanggal_kembali);
        $dendaperhari = 2000;

        if (strtotime($tanggal_sekarang) > strtotime($tanggal_kembali)) {
            $jumlah_hari = $tanggal_kembali->diff($tanggal_sekarang)->days;
            $denda = $jumlah_hari * $dendaperhari;
        } else {
            $denda = 0;
        }

        // Membuat data pengembalian
        $save = pengembalianBukuModel::create([
            'id_peminjaman_buku' => $req->id_peminjaman_buku,
            'tanggal_pengembalian' => $tanggal_sekarang,
            'denda' => $denda
        ]);

        if ($save) {
            $data['status'] = 1;
            $data['message'] = 'Berhasil dikembalikan';
        } else {
            $data['status'] = 0;
            $data['message'] = 'Pengembalian gagal';
        }

    } else {
        $data = ['status' => 0, 'message' => 'Sudah pernah dikembalikan'];
    }

    return response()->json($data);
}
}