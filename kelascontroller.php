<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kelasModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class kelascontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function getkelas()
    {
        $dt_kelas= kelasModel::get();
        return response()->json($dt_kelas);
    }
    
    public function addkelas(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id_kelas'=>'required',
            'nama_kelas' => 'required',
            'kelompok' =>'required',
            'angkatan' => 'required',
          
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $save = kelasModel::create([
            'id_kelas'=> $req ->get ('id_kelas'),
            'nama_kelas' => $req->get('nama_kelas'),
            'kelompok' => $req->get('kelompok'),
            'angkatan' => $req->get('angkatan'),
           
        ]);
        if ($save) {
            return response()->json(['status' => true, 'message' => 'Sukses Mengubah Data Kelas']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal Mengubah Data Kelas']);
        }
    }
    
    public function updatekelas(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'nama_kelas' => 'required',
            'kelompok' =>'required',
            'angkatan' => 'required',
           

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $ubah = kelasModel::where('id_kelas', $id)->update([
            'nama_kelas' => $req->get('nama_kelas'),
            'kelompok' => $req->get('kelompok'),
            'angkatan' => $req->get('angkatan'),
        
            
        ]);

        if ($ubah) {
            return response()->json(['status' => true, 'message' => 'Sukses Menambahkan Data Kelas']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal Menambahkan Data Kelas']);
        }
    }
    public function getkelasid($id)
    {
    $dt=kelasModel::where('id_kelas',$id)->first();
    return response()->json($dt);
    }
    public function deletekelas($id)
    {
       
        $hapus=kelasModel::where ('id_kelas',$id)->delete();
        if($hapus){
        return response ()->json(['status'=> true, 'massage'=>'sukses hapus data Kelas!!']);
    }else{
        return response ()->json(['status'=> false, 'massage'=>'gagal hapus Kelas!!']);
    }
}
}