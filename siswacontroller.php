<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\siswamodel;
use App\Models\kelasModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class siswacontroller extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function getsiswa()
    {
        $dt_siswa=siswamodel::get();
        return response()->json($dt_siswa);
    }
    public function addsiswa(Request $req)
    {
        $validator = validator::make($req->all(),[
            'nama_siswa' => 'required',
            'tanggal_lahir' => 'required',
            'gender'=>'required',
            'alamat'=>'required',
            'username'=>'required',
            'password'=>'required',
            'id_kelas'=>'required',
            
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $save = siswamodel::create([
            'nama_siswa' => $req->get('nama_siswa'),
            'tanggal_lahir' => $req->get('tanggal_lahir'), 
            'gender' => $req->get('gender'),
            'alamat' => $req->get('alamat'),
            'username' => $req->get('username'), 
            'password'=>$req->get ('password'),
            'id_kelas'=>$req->get('id_kelas'),

        ]);
        if($save){
            return response()->json(['status' => true,'message' => 'Sukses Menambahkan Data Siswa!!']);
        }else{
            return response()->json(['status'=>false,'message'=> 'Gagal Menambahkan Data Siswa!!']);
        }
    }
    public function updatesiswa (Request $req, $id){
        $validator = Validator::make($req->all(),[
            'nama_siswa' => 'required',
            'tanggal_lahir' => 'required',
            'gender'=>'required',
            'alamat'=>'required',
            'username'=>'required',
            'password'=>'required',
            'id_kelas'=>'required',
            
        ]);
    if ($validator->fails()){
        return response()->json($validator->errors()->toJson());
    }
    $ubah = siswamodel::where('id_siswa',$id)->update([  
            'nama_siswa' => $req->get('nama_siswa'),
            'tanggal_lahir' => $req->get('tanggal_lahir'), 
            'gender' => $req->get('gender'),
            'alamat' => $req->get('alamat'),
            'username' => $req->get('username'), 
            'password'=>$req->get ('password'),
            'id_kelas'=>$req->get('id_kelas'),
    ]);

    if ($ubah){
        return response()->json(['status'=>true,'message'=>'Sukses Mengubah Data Siswa!!']);
    } else {
        return response()->json(['status'=>false,'message'=>'Gagal Mengubah Data Siswa!!']);
    }
    }

    public function getsiswaid($id)
    {
        $dt=siswamodel::Where('id_siswa',$id)->first();
        return response()->json($dt);
    }

     public function deletesiswa($id)
    {
    $hapus=siswamodel::where('id_siswa',$id)->delete();
    if($hapus){
        return response()->json(['status'=>true, 'message'=>'Sukses Hapus Data Siswa!!']);
    } else {
        return response()->json(['status'=>false,'message'=>'Gagal Hapus Data Siswa']);
    }
}

}