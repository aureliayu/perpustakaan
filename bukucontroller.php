<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bukuModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class bukucontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function getbuku()
    {
        $dt_buku= bukuModel::get();
        return response()->json($dt_buku);
    }
    
    public function addbuku(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nama_buku' => 'required',
            'pengarang' =>'required',
            'deskripsi' => 'required',
          
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $save = bukuModel::create([
            'nama_buku' => $req->get('nama_buku'),
            'pengarang' => $req->get('pengarang'),
            'deskripsi' => $req->get('deskripsi'),
           
        ]);
        if ($save) {
            return response()->json(['status' => true, 'message' => 'Sukses Menambahkan Data Buku!!!']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal Menambahkan Data Buku!!!']);
        }
    }
    
    public function updatebuku(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'nama_buku' => 'required',
            'pengarang' =>'required',
            'deskripsi' => 'required',
           

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $ubah =bukuModel::where('id_buku', $id)->update([
            'nama_buku' => $req->get('nama_buku'),
            'pengarang' => $req->get('pengarang'),
            'deskripsi' => $req->get('deskripsi'),
        
            
        ]);

        if ($ubah) {
            return response()->json(['status' => true, 'message' => 'Sukses Menambahkan Data Buku!!! ']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal Menambahkan Data Buku!!!']);
        }
    }
    public function getbukuid($id)
    {
    $dt=bukuModel::where('id_buku',$id)->first();
    return response()->json($dt);
    }
    public function deletebuku($id)
    {
       
        $hapus=bukuModel::where ('id_buku',$id)->delete();
        if($hapus){
        return response ()->json(['status'=> true, 'massage'=>'sukses hapus data Buku!!']);
    }else{
        return response ()->json(['status'=> false, 'massage'=>'gagal hapus Buku!!']);
    }
}


}