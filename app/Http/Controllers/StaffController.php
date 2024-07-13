<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use App\Models\Ruangan;
use App\Models\Kategori;
use App\Models\Barang;
use App\Models\Perencanaan;
use App\Models\Pengadaan;
use App\Models\Pendistribusian;
use App\Models\Inventaris;
use App\Models\Pemeliharaan;
use App\Models\StokGudang;
use App\Models\PerencanaanDetail;
use App\Models\PengadaanDetail;
use App\Models\PendistribusianDetail;
use App\Models\PemeliharaanDetail;
use App\Models\StockGudang;
use Illuminate\Support\Facades\Hash;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use PDF;
use Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        $data1 = Perencanaan::where('user_id',auth()->user()->id)->count();
        $data2 = Pengadaan::count();
        $data3 = Inventaris::count();
        $data4 = StokGudang::count();
        return view('staff.home', compact('user','data1','data2','data3','data4'));
    }
    public function perencanaan()
    {
        $user = Auth::user();
        $perencanaan = Perencanaan::where('user_id',auth()->user()->id)->with('ruangan','user')->get();
        $ruangan = Ruangan::all();
        return view('staff.perencanaan', compact( 'user','perencanaan','ruangan'));
    }

    public function submit_perencanaan(Request $req){
        $id = IdGenerator::generate(['table' => 'perencanaans','field'=>'kode', 'length' => 7, 'prefix' =>'PR']);
            { $validate = $req->validate([
                'tanggal'=> 'required',
              
                'ruangan'=> 'required',
                
            ]);
            $perencanaan = new Perencanaan;
            $perencanaan->kode = $id;
            $perencanaan->tanggal_perencanaan = $req->get('tanggal');
            $perencanaan->keterangan = null;
            $perencanaan->status ="Belum Diajukan";
            $perencanaan->user_id =auth()->user()->id;
            $perencanaan->ruangan_id =$req->get('ruangan');
            $perencanaan->save();
            Session::flash('status', 'Tambah data Pengajuan berhasil!!!');
            return redirect()->route('staff.perencanaan');
        }}
        public function getDataPerencanaan($id)
        {
            $perencanaan = Perencanaan::find($id);
            return response()->json($perencanaan);
        }
    public function update_perencanaan(Request $req){
        $perencanaan= Perencanaan::find($req->get('id'));
        { $validate = $req->validate([
            'tanggal'=> 'required',
                'status'=> 'required|max:20',
                'ruangan'=> 'required',
        ]);
        $perencanaan->kode = $req->get('kode');
        $perencanaan->tanggal_perencanaan = $req->get('tanggal');
        $perencanaan->keterangan = null;
        $perencanaan->status =$req->get('status');
        $perencanaan->user_id =auth()->user()->id;
        $perencanaan->ruangan_id =$req->get('ruangan');
        $perencanaan->save();
        Session::flash('status', 'Ubah data Pengajuan berhasil!!!');
        return redirect()->route('staff.perencanaan');
        }}

        public function delete_perencanaan($id)
        {
            $perencanaan = Perencanaan::find($id);
            $perencanaan->delete();
    
            $success = true;
            $message = "Data Pengajuan Berhasil Dihapus";
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
        }
    public function perencanaan_detail($id)
    {
        $user = Auth::user();
        $perencanaan = Perencanaan::where('id',$id)->get();
        $perencanaan_detail = PerencanaanDetail::where('perencanaan_id',$id)->get();
        $barang = Barang::all();
        return view('staff.perencanaan_detail', compact( 'user','perencanaan_detail','perencanaan','barang'));
    }

    public function submit_perencanaan_detail(Request $req){
            { $validate = $req->validate([
                'barang'=> 'required',
                'merk'=> 'required|max:20',
                'jumlah'=> 'required|integer',
                'harga'=> 'required|integer',
                'keterangan'=> 'required',
                
            ]);
            $jumlah=$req->get('jumlah');
            $harga=$req->get('harga');
            $perencanaandetail = new PerencanaanDetail;
            $perencanaandetail->barang_id = $req->get('barang');
            $perencanaandetail->merk = $req->get('merk');
            $perencanaandetail->harga =$req->get('harga');
            $perencanaandetail->qty =$req->get('jumlah');
            $perencanaandetail->keterangan =$req->get('keterangan');
            $perencanaandetail->total=$jumlah*$harga;
            $perencanaandetail->perencanaan_id =$req->get('perencanaan');
            $perencanaandetail->save();
            Session::flash('status', 'Tambah data Pengajuan Detail berhasil!!!');
            return redirect()->back();
        }}
        public function getDataPerencanaanDetail($id)
        {
            $perencanaandetail = PerencanaanDetail::find($id);
            return response()->json($perencanaandetail);
        }
    public function update_perencanaan_detail(Request $req){
        $perencanaandetail= PerencanaanDetail::find($req->get('id'));
        { $validate = $req->validate([
            'barang'=> 'required',
            'merk'=> 'required|max:20',
            'jumlah'=> 'required|integer',
            'harga'=> 'required|integer',
            'keterangan'=> 'required',
        ]);
        $jumlah=$req->get('jumlah');
        $harga=$req->get('harga');
        $perencanaandetail->barang_id = $req->get('barang');
        $perencanaandetail->merk = $req->get('merk');
        $perencanaandetail->harga =$req->get('harga');
        $perencanaandetail->qty =$req->get('jumlah');
        $perencanaandetail->keterangan =$req->get('keterangan');
        $perencanaandetail->total=$jumlah*$harga;
        $perencanaandetail->perencanaan_id =$req->get('perencanaan');
        $perencanaandetail->save();
        Session::flash('status', 'Ubah data Pengajuan Detail berhasil!!!');
        return redirect()->back();
        }}

        public function delete_perencanaan_detail($id)
        {
            $perencanaandetail = PerencanaanDetail::find($id);
            $perencanaandetail->delete();
    
            $success = true;
            $message = "Data Pengajuan Detail Berhasil Dihapus";
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
        }
        public function pendistribusian()
        {
            $user = Auth::user();
            $pendistribusian = Pendistribusian::where('penerima',auth()->user()->name)->with('pengadaan')->get();
            $ruangan = Ruangan::all();
            $staff = User::where('roles_id',3)->get();
            return view('staff.pendistribusian', compact( 'user','pendistribusian','ruangan','staff'));
        }
        public function pendistribusian_detail($id)
        {
            $user = Auth::user();
            $pendistribusian = Pendistribusian::where('id',$id)->get();
            $pendistribusian_detail = PendistribusianDetail::where('pendistribusian_id',$id)->get();
            return view('staff.pendistribusian_detail', compact( 'user','pendistribusian_detail','pendistribusian'));
        }
        public function getDataPendistribusian($id)
        {
            $pendistribusian = Pendistribusian::find($id);
            return response()->json($pendistribusian);
        }
            public function pendistribusian_terima($id){
                $terima = DB::table('pendistribusians')->where('id', $id)->update([ 'keterangan' => 1,]);
                Session::flash('status', 'Pendistribusian Berhasil Diterima!!!');
                $pendistribusian = Pendistribusian::where('id', $id)->value('ruangan_id');
                $ruangan = Ruangan::where('id', $pendistribusian)->value('nama_ruangan');
                $detail = PendistribusianDetail::where('pendistribusian_id', $id)->get();
                foreach ($detail as $d){
                    $barang = Barang::where('id', $d->barang_id)->value('kategori_id');
                    $kategori = Kategori::where('id', $barang)->value('nama_kategori');
                    $kode = IdGenerator::generate(['table' => 'inventaris','field'=>'kode', 'length' => 10, 'prefix' =>'INV-']);
                    if($kategori =='Sekali Pakai'){
                        $inventaris = new Inventaris;
                        $inventaris->kode = null;
                        $inventaris->tanggal =  Carbon::now();
                        $inventaris->ruangan = $ruangan;
                        $inventaris->keterangan = $d->total;
                        $inventaris->jumlah = $d->qty;
                        $inventaris->merk = $d->merk;
                        $inventaris->barang_id =$d->barang_id;
                        $inventaris->pendistribusian_id =$id;
                        $inventaris->save();
                    }else{
                    $inventaris = new Inventaris;
                    $inventaris->kode = $kode;
                    $inventaris->tanggal =  Carbon::now();
                    $inventaris->ruangan = $ruangan;
                    $inventaris->keterangan = $d->total;
                    $inventaris->jumlah = $d->qty;
                    $inventaris->merk = $d->merk;
                    $inventaris->barang_id =$d->barang_id;
                    $inventaris->pendistribusian_id =$id;
                    $inventaris->save();
                }
                }
                return redirect()->back();
            }
            public function inventaris()
            {
                $user = Auth::user();
                $inventaris = Inventaris::where('jumlah','!=',0)->with('barang')->get();
                return view('staff.inventaris', compact( 'user','inventaris'));
            }

            public function pemeliharaan()
            {
                $user = Auth::user();
                $pemeliharaan = Pemeliharaan::all();
                $pengguna = User::all();
                return view('staff.pemeliharaan', compact( 'user','pemeliharaan','pengguna'));
            }
            
            public function submit_pemeliharaan(Request $req){
            $id = IdGenerator::generate(['table' => 'pemeliharaans','field'=>'kode', 'length' => 7, 'prefix' =>'PM']);
            { $validate = $req->validate([
                'tanggal'=> 'required',
                'keterangan'=> 'required',
                
            ]);
            $pemeliharaan = new Pemeliharaan;
            $pemeliharaan->kode = $id;
            $pemeliharaan->tanggal_pemeliharaan = $req->get('tanggal');
            $pemeliharaan->keterangan = $req->get('keterangan');;
            $pemeliharaan->petugas =auth()->user()->name;
            $pemeliharaan->save();
            Session::flash('status', 'Tambah data Pemeliharaan berhasil!!!');
            return redirect()->route('staff.pemeliharaan');
        }}
        public function getDataPemeliharaan($id)
        {
            $pemeliharaan = Pemeliharaan::find($id);
            return response()->json($pemeliharaan);
        }
    public function update_pemeliharaan(Request $req){
        $pemeliharaan = Pemeliharaan::find($req->get('id'));
        { $validate = $req->validate([
            'tanggal'=> 'required',
               
                'keterangan'=> 'required',
        ]);
        $pemeliharaan->kode = $req->get('kode');
            $pemeliharaan->tanggal_pemeliharaan = $req->get('tanggal');
            $pemeliharaan->keterangan = $req->get('keterangan');;
            $pemeliharaan->petugas =$req->get('petugas');
            $pemeliharaan->save();
        Session::flash('status', 'Ubah data Pemeliharaan berhasil!!!');
        return redirect()->route('staff.pemeliharaan');
        }}

        public function delete_pemeliharaan($id)
        {
            $pemeliharaan = Pemeliharaan::find($id);
            $pemeliharaan->delete();
    
            $success = true;
            $message = "Data Pemeliharaan Berhasil Dihapus";
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
        }

        public function pemeliharaan_detail($id)
        {
            $user = Auth::user();
            $pemeliharaan = Pemeliharaan::where('id',$id)->get();
            $pemeliharaan_detail = PemeliharaanDetail::where('pemeliharaan_id',$id)->get();
            $inventaris = Inventaris::where('jumlah','!=',0)->with('barang')->get();
            $petugas = Pemeliharaan::where('id',$id)->value('petugas');
            return view('staff.pemeliharaan_detail', compact( 'user','pemeliharaan_detail','pemeliharaan','inventaris','petugas'));
        }
    
        public function submit_pemeliharaan_detail(Request $req){
                { $validate = $req->validate([
                    'inventaris'=> 'required',
                    'status'=> 'required',
                    'jumlah'=> 'required',
                    'keterangan'=> 'required',
                    
                ]);
                $inven = Inventaris::where('id',$req->get('inventaris'))->value('barang_id');
                $inventaris = Inventaris::where('id',$req->get('inventaris'))->value('jumlah');
                $inventarsi = Inventaris::where('id',$req->get('inventaris'))->value('kode');
                $barang = Barang::where('id',$inven)->value('id');
                $kode1 = Barang::where('id',$inven)->value('kode');
if($inventaris<$req->get('jumlah')){
    Session::flash('status', 'Jumlah Inventarsis yang anda Masukan terlalu Besar!!!');
    return redirect()->back();
}
else{
if( $req->get('status') == "Baik"){
    $kode = IdGenerator::generate(['table' => 'pemeliharaan_details','field'=>'kode', 'length' => 7, 'prefix' =>'PD']);
    $pemeliharaandetail = new PemeliharaanDetail;
    $pemeliharaandetail->kode =$kode;
    $pemeliharaandetail->status =$req->get('status');
    $pemeliharaandetail->jumlah =$req->get('jumlah');
    $pemeliharaandetail->keterangan =$req->get('keterangan');
    $pemeliharaandetail->barang_id =$barang;
    $pemeliharaandetail->inventaris_id =$req->get('inventaris');
    $pemeliharaandetail->pemeliharaan_id =$req->get('pemeliharaan');
    $pemeliharaandetail->save();
    Session::flash('status', 'Tambah data Pemeliharaan Detail berhasil!!!');
    return redirect()->back();
}
else if( $req->get('status') == "Rusak Ringan"){
    $kode = IdGenerator::generate(['table' => 'pemeliharaan_details','field'=>'kode', 'length' => 7, 'prefix' =>'PD']);
    $pemeliharaandetail = new PemeliharaanDetail;
    $pemeliharaandetail->kode =$kode;
    $pemeliharaandetail->status =$req->get('status');
    $pemeliharaandetail->jumlah =$req->get('jumlah');
    $pemeliharaandetail->keterangan =$req->get('keterangan');
    $pemeliharaandetail->barang_id =$barang;
    $pemeliharaandetail->inventaris_id =$req->get('inventaris');
    $pemeliharaandetail->pemeliharaan_id =$req->get('pemeliharaan');
    $pemeliharaandetail->save();
    Session::flash('status', 'Tambah data Pemeliharaan Detail berhasil!!!');
    return redirect()->back();
}
else if( $req->get('status') == "Habis"){
    $kode = IdGenerator::generate(['table' => 'pemeliharaan_details','field'=>'kode', 'length' => 7, 'prefix' =>'PD']);
    $pemeliharaandetail = new PemeliharaanDetail;
    $pemeliharaandetail->kode =$kode;
    $pemeliharaandetail->status =$req->get('status');
    $pemeliharaandetail->jumlah =$req->get('jumlah');
    $pemeliharaandetail->keterangan =$req->get('keterangan');
    $pemeliharaandetail->barang_id =$barang;
    $pemeliharaandetail->inventaris_id =$req->get('inventaris');
    $pemeliharaandetail->pemeliharaan_id =$req->get('pemeliharaan');
    $pemeliharaandetail->save();
    $total = $inventaris - $req->get('jumlah');
    $terima = DB::table('inventaris')->where('id', $req->get('inventaris'))->update([ 'jumlah' =>$total,]);
    Session::flash('status', 'Tambah data Pemeliharaan Detail berhasil!!!');
    return redirect()->back();
}
else{
    $kode = IdGenerator::generate(['table' => 'pemeliharaan_details','field'=>'kode', 'length' => 7, 'prefix' =>'PD']);
    $pemeliharaandetail = new PemeliharaanDetail;
    $pemeliharaandetail->kode =$kode;
    $pemeliharaandetail->status =$req->get('status');
    $pemeliharaandetail->jumlah =$req->get('jumlah');
    $pemeliharaandetail->keterangan =$req->get('keterangan');
    $pemeliharaandetail->barang_id =$barang;
    $pemeliharaandetail->inventaris_id =$req->get('inventaris');
    $pemeliharaandetail->pemeliharaan_id =$req->get('pemeliharaan');
    $pemeliharaandetail->save();
    $pemeliharaan_detail_id = DB::table('pemeliharaan_details')->where('kode',$kode)->value('id');
    $stok_gudang = new StokGudang;
    $stok_gudang->tanggal = Carbon::now();
    $stok_gudang->kode_barang =$kode1;
    $stok_gudang->status =$req->get('status');
    $stok_gudang->jumlah =$req->get('jumlah');
    $stok_gudang->pemeliharaan_detail_id = $pemeliharaan_detail_id;
    $stok_gudang->kode_inventaris =$inventarsi;
    $stok_gudang->save();
    $total = $inventaris - $req->get('jumlah');
    $terima = DB::table('inventaris')->where('id', $req->get('inventaris'))->update([ 'jumlah' =>$total,]);
   
    Session::flash('status', 'Tambah data Pemeliharaan Detail berhasil!!!');
    return redirect()->back();
}
}
            }}
            public function getDataPemeliharaanDetail($id)
            {
                $pemeliharaandetail = PemeliharaanDetail::find($id);
                return response()->json($pemeliharaandetail);
            }
        public function update_pemeliharaan_detail(Request $req){
            $pemeliharaandetail= PemeliharaanDetail::find($req->get('id'));
            { $validate = $req->validate([
                'inventaris'=> 'required',
                'status'=> 'required',
                'jumlah'=> 'required',
                'keterangan'=> 'required', 
            ]);
            $inven = Inventaris::where('id',$req->get('inventaris'))->value('barang_id');
            $barang = Barang::where('id',$inven)->value('kode');
            $pemeliharaandetail->status =$req->get('status');
            $pemeliharaandetail->jumlah =$req->get('jumlah');
            $pemeliharaandetail->keterangan =$req->get('keterangan');
            $pemeliharaandetail->barang_id =$barang;
            $pemeliharaandetail->inventaris_id =$req->get('inventaris');
            $pemeliharaandetail->pemeliharaan_id =$req->get('pemeliharaan');
            $pemeliharaandetail->save();
            Session::flash('status', 'Ubah data Pemeliharaan Detail berhasil!!!');
            return redirect()->back();
            }}
    
            public function delete_pemeliharaan_detail($id)
            {
                $pemeliharaandetail = PemeliharaanDetail::find($id);
                $pemeliharaandetail->delete();
        
                $success = true;
                $message = "Data Pemeliharaan Detail Berhasil Dihapus";
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
         
}
