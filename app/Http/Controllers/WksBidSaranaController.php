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

class WksBidSaranaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function index()
    {
        $user = Auth::user();
        $data1 = Perencanaan::count();
        $data2 = Pengadaan::count();
        $data3 = Inventaris::count();
        $data4 = StokGudang::where('status','!=','Hilang')->count();
        return view('sarana.home', compact('user','data1','data2','data3','data4'));
    }
 
    public function ruangan()
    {
        $user = Auth::user();
        $ruangan = Ruangan::all();
        return view('sarana.ruangan', compact( 'user','ruangan'));
    }

    public function submit_ruangan(Request $req){
        $id = IdGenerator::generate(['table' => 'ruangans','field'=>'kode', 'length' => 7, 'prefix' =>'RA']);
            { $validate = $req->validate([
                'nama'=> 'required|max:25',
                'luas'=> 'required|max:5',
                'foto'=> 'required|max:2000',
            ]);
            $ruangan = new Ruangan;
            $ruangan->kode = $id;
            $ruangan->nama_ruangan = $req->get('nama');
            $ruangan->luas = $req->get('luas');
            if($req->hasFile('foto'))
            {
                $extension = $req->file('foto')->extension();
                $filename = 'foto'.time().'.'.$extension;
                $req->file('foto')->storeAS('public/ruangan', $filename);
                $ruangan->foto = $filename;
            }
            $ruangan->save();
            Session::flash('status', 'Tambah data Ruangan berhasil!!!');
            return redirect()->route('sarana.ruangan');
        }}
        public function getDataRuangan($id)
        {
            $ruangan = Ruangan::find($id);
            return response()->json($ruangan);
        }
    public function update_ruangan(Request $req){
        $ruangan= Ruangan::find($req->get('id'));
        { $validate = $req->validate([
            'nama'=> 'required|max:25',
            'luas'=> 'required|max:5',
            'foto'=> 'required|max:2000',
        ]);
        $ruangan->kode = $req->get('kode');
        $ruangan->nama_ruangan = $req->get('nama');
        $ruangan->luas = $req->get('luas');
        if($req->hasFile('foto'))
        {
            $extension = $req->file('foto')->extension();
            $filename = 'foto'.time().'.'.$extension;
            $req->file('foto')->storeAS('public/ruangan', $filename);
            Storage::delete('public/ruangan/'.$req->get('old_foto'));
            $ruangan->foto = $filename;
        }
        $ruangan->save();
        Session::flash('status', 'Ubah data Ruangan berhasil!!!');
        return redirect()->route('sarana.ruangan');
        }}

        public function delete_ruangan($id)
        {
            $ruangan = Ruangan::find($id);
            Storage::delete('public/ruangan/'.$ruangan->foto);
            $ruangan->delete();
    
            $success = true;
            $message = "Data Ruangan Berhasil Dihapus";
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
        }
    public function kategori()
    {
        $user = Auth::user();
        $kategori = Kategori::all();
        return view('sarana.kategori', compact( 'user','kategori'));
    }

    public function submit_kategori(Request $req){
        $id = IdGenerator::generate(['table' => 'kategoris','field'=>'kode', 'length' => 7, 'prefix' =>'KT']);
            { $validate = $req->validate([
                'nama'=> 'required|max:20',
                
            ]);
            $kategori = new Kategori;
            $kategori->kode = $id;
            $kategori->nama_kategori = $req->get('nama');
            $kategori->save();
            Session::flash('status', 'Tambah data Kategori berhasil!!!');
            return redirect()->route('sarana.kategori');
        }}
        public function getDataKategori($id)
        {
            $kategori = Kategori::find($id);
            return response()->json($kategori);
        }
    public function update_kategori(Request $req){
        $kategori= Kategori::find($req->get('id'));
        { $validate = $req->validate([
            'nama'=> 'required|max:20',
        ]);
        $kategori->kode = $req->get('kode');
        $kategori->nama_kategori = $req->get('nama');
        $kategori->save();
        Session::flash('status', 'Ubah data Kategori berhasil!!!');
        return redirect()->route('sarana.kategori');
        }}

        public function delete_kategori($id)
        {
            $kategori = Kategori::find($id);
            $kategori->delete();
    
            $success = true;
            $message = "Data Kategori Berhasil Dihapus";
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
        }

    public function barang()
    {
        $user = Auth::user();
        $barang = Barang::all();
        $kategori = Kategori::all();
        return view('sarana.barang', compact( 'user','barang','kategori'));
    }

    public function submit_barang(Request $req){
        $id = IdGenerator::generate(['table' => 'barangs','field'=>'kode', 'length' => 7, 'prefix' =>'BR']);
            { $validate = $req->validate([
                'nama'=> 'required|max:20',
                'kategori'=> 'required|max:50',
                
            ]);
            $barang = new Barang;
            $barang->kode = $id;
            $barang->nama_barang = $req->get('nama');
            $barang->kategori_id = $req->get('kategori');
            $barang->save();
            Session::flash('status', 'Tambah data Barang berhasil!!!');
            return redirect()->route('sarana.barang');
        }}
        public function getDataBarang($id)
        {
            $barang = Barang::find($id);
            return response()->json($barang);
        }
    public function update_barang(Request $req){
        $barang= Barang::find($req->get('id'));
        { $validate = $req->validate([
            'nama'=> 'required|max:20',
            'kategori'=> 'required|max:50',
        ]);
        $barang->kode = $req->get('kode');
        $barang->nama_barang = $req->get('nama');
        $barang->kategori_id = $req->get('kategori');
        $barang->save();
        Session::flash('status', 'Ubah data Barang berhasil!!!');
        return redirect()->route('sarana.barang');
        }}

        public function delete_barang($id)
        {
            $barang = Barang::find($id);
            $barang->delete();
    
            $success = true;
            $message = "Data Barang Berhasil Dihapus";
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
        }

    public function perencanaan()
    {
        $user = Auth::user();
        $perencanaan = Perencanaan::with('ruangan','user')->get();
        $perencanaans = Perencanaan::where('user_id', Auth::user()->id)->value('id');
        $ruangan = Ruangan::all();
        return view('sarana.perencanaan', compact( 'user','perencanaan','perencanaans','ruangan'));
    }

    public function submit_perencanaan(Request $req){
        $id = IdGenerator::generate(['table' => 'perencanaans','field'=>'kode', 'length' => 7, 'prefix' =>'PR']);
            { $validate = $req->validate([
                'tanggal'=> 'required',
                'status'=> 'required|max:20',
                'ruangan'=> 'required',
                
            ]);
            $perencanaan = new Perencanaan;
            $perencanaan->kode = $id;
            $perencanaan->tanggal_perencanaan = $req->get('tanggal');
            $perencanaan->keterangan = null;
            $perencanaan->status =$req->get('status');
            $perencanaan->user_id =auth()->user()->id;
            $perencanaan->ruangan_id =$req->get('ruangan');
            $perencanaan->save();
            Session::flash('status', 'Tambah data Pengajuan berhasil!!!');
            return redirect()->route('sarana.perencanaan');
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
        $perencanaan->user_id =$req->get('user_id');
        $perencanaan->ruangan_id =$req->get('ruangan');
        $perencanaan->save();
        Session::flash('status', 'Ubah data Pengajuan berhasil!!!');
        return redirect()->route('sarana.perencanaan');
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
        $perencanaans = Perencanaan::where('user_id', Auth::user()->id)->value('id');
        $perencanaan = Perencanaan::where('id',$id)->get();
        $perencanaan_detail = PerencanaanDetail::where('perencanaan_id',$id)->get();
        $barang = Barang::all();
        return view('sarana.perencanaan_detail', compact( 'user','perencanaan_detail','perencanaans','perencanaan','barang'));
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
        public function pengadaan()
        {
            $user = Auth::user();
            $pengadaan = Pengadaan::with('ruangan','perencanaan')->get();
            $total = Pengadaan::sum('harga');
            $jumlah = PengadaanDetail::where('status',1)->sum('total');
            $sisa = $total-$jumlah;
            $pengadaan_detail = PengadaanDetail::where('status',1)->get();
            return view('sarana.pengadaan', compact( 'user','pengadaan','pengadaan_detail' ,'total','sisa'));
        }
        public function pengadaan_detail($id)
        {
            $user = Auth::user();
            $pengadaan = Pengadaan::where('id',$id)->get();
            $pengadaan_detail = PengadaanDetail::where('pengadaan_id',$id)->get();
            $barang = Barang::all();
            return view('sarana.pengadaan_detail', compact( 'user','pengadaan_detail','pengadaan','barang'));
        }
        public function getDataPengadaanDetail($id)
        {
            $pengadaan_detail = PengadaanDetail::find($id);
            return response()->json($pengadaan_detail);
        }
        public function update_pengadaan_detail(Request $req){
            $pengadaandetail= PengadaanDetail::find($req->get('id'));
            { $validate = $req->validate([
                'barang'=> 'required',
                'merk'=> 'required|max:20',
                'jumlah'=> 'required|integer',
                'harga'=> 'required|integer',
                'status'=> 'required',
            ]);
            $jumlah=$req->get('jumlah');
            $harga=$req->get('harga');
            $pengadaandetail->barang_id = $req->get('barang');
            $pengadaandetail->merk = $req->get('merk');
            $pengadaandetail->harga =$req->get('harga');
            $pengadaandetail->qty =$req->get('jumlah');
            $pengadaandetail->status =$req->get('status');
            $pengadaandetail->total=$jumlah*$harga;
            $pengadaandetail->pengadaan_id =$req->get('pengadaan');
            $pengadaandetail->save();
            Session::flash('status', 'Ubah data Pengadaan Detail berhasil!!!');
            return redirect()->back();
            }}
            public function setujui_pengadaan_detail($id){
                $terima = DB::table('pengadaan_details')->where('id', $id)->update([ 'status' => 1,]);
                Session::flash('status', 'Barang Berhasil Diadakan!!!');
                return redirect()->back();
            }
            public function distribusikan($id){
                $terima = DB::table('pengadaans')->where('id', $id)->update([ 'keterangan' => 'Barang Sudah Di Distribusikan',]);
                $cek1 = Pendistribusian::where('id', $id)->value('kode');
                $id1 = Pengadaan::where('id', $id)->value('id');
                $user = Pengadaan::where('id', $id)->value('user_id');
                $ruangan = Pengadaan::where('id', $id)->value('ruangan_id');
                $penerima = Pengadaan::where('id', $id)->value('user_id');
                $terima = User::where('id', $penerima)->value('name');
                $detail = PengadaanDetail::where('pengadaan_id', $id)->where('status',1)->get();
                if($cek1 == null){
                    $id = IdGenerator::generate(['table' => 'pendistribusians','field'=>'kode', 'length' => 7, 'prefix' =>'PD']);
                $pendistribusian = new Pendistribusian;
                $pendistribusian->kode = $id;
                $pendistribusian->tanggal_pendistribusian = Carbon::now();
                $pendistribusian->keterangan = null;
                $pendistribusian->penerima = $terima;
                $pendistribusian->pengadaan_id = $id1;
                $pendistribusian->ruangan_id =$ruangan;;
                $pendistribusian->save();
                    foreach ($detail as $d){
                        $pendistribusian_id = Pendistribusian::where('kode', $id)->value('id');
                        $pendistribusian_detail = new PendistribusianDetail;
                        $pendistribusian_detail->qty = $d->qty;
                        $pendistribusian_detail->merk =$d->merk;
                        $pendistribusian_detail->barang_id =$d->barang_id;
                        $pendistribusian_detail->pendistribusian_id =$pendistribusian_id;
                        $pendistribusian_detail->save();
                    }
                Session::flash('status', 'Barang Sudah Di Distribusikan!!!');
                return redirect()->route('sarana.pendistribusian');
                  }else{
                    Session::flash('status', 'Barang Sudah Di Distribusikan!!!');
                    return redirect()->route('sarana.pendistribusian');
               
            }
            }

            public function pendistribusian()
            {
                $user = Auth::user();
                $pendistribusian = Pendistribusian::with('pengadaan')->get();
                $ruangan = Ruangan::all();
                $staff = User::where('roles_id',3)->get();
                return view('sarana.pendistribusian', compact( 'user','pendistribusian','ruangan','staff'));
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
            public function pendistribusian_detail($id)
            {
                $user = Auth::user();
                $pendistribusian = Pendistribusian::where('id',$id)->get();
                $pendistribusian_detail = PendistribusianDetail::where('pendistribusian_id',$id)->get();
                return view('sarana.pendistribusian_detail', compact( 'user','pendistribusian_detail','pendistribusian'));
            }
            public function getDataPendistribusian($id)
            {
                $pendistribusian = Pendistribusian::find($id);
                return response()->json($pendistribusian);
            }
            public function inventaris()
            {
                $user = Auth::user();
                $inventaris = Inventaris::where('jumlah','!=',0)->with('barang')->get();
                return view('sarana.inventaris', compact( 'user','inventaris'));
            }
            public function getDataInventaris($id)
            {
                $inventaris = Inventaris::find($id);
                return response()->json($inventaris);
            }
            public function update_inventaris(Request $req)
            {
                $terima = DB::table('inventaris')->where('id', $req->get('id'))->update([ 'keterangan' => $req->get('status'),]);
                Session::flash('status', 'Inventaris Berhasil Diubah!!!');
                return redirect()->route('sarana.inventaris');
            }

            public function pemeliharaan()
            {
                $user = Auth::user();
                $pemeliharaan = Pemeliharaan::all();
                $pengguna = User::all();
                return view('sarana.pemeliharaan', compact( 'user','pemeliharaan','pengguna'));
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
            return redirect()->route('sarana.pemeliharaan');
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
        return redirect()->route('sarana.pemeliharaan');
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
            return view('sarana.pemeliharaan_detail', compact( 'user','pemeliharaan_detail','pemeliharaan','inventaris','petugas'));
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

            public function stock_gudang()
            {
                $user = Auth::user();
                $stock_gudang = StokGudang::where('status','!=','Hilang')->get();
                return view('sarana.stock_gudang', compact( 'user','stock_gudang'));
            }

            public function data_user(){
                $user = Auth::user();
                $pengguna = User::with('roles')->get();
                $roles = Roles::all();
                return view('sarana.pengguna', compact('user','pengguna','roles'));
            }
        
            public function submit_user(Request $req){
                { $validate = $req->validate([
                    'ids'=> 'required',
                    'nama'=> 'required',
                    'username'=> 'required',
                    'email'=> 'required',
                    'password'=> 'required',
                    'roles_id'=> 'required',
                ]);
                
                $user = new User;
                $user->id_status = $req->get('ids');
                $user->name = $req->get('nama');
                $user->username = $req->get('username');
                $user->email = $req->get('email');
                $user->password = Hash::make($req->get('password'));
                $user->roles_id = $req->get('roles_id');
                $user->email_verified_at = null;
                $user->remember_token = null;
                $user->save();
                Session::flash('status', 'Tambah data Pengguna berhasil!!!');
                return redirect()->route('sarana.pengguna');
            }}
            public function getDataUser($id)
            {
                $user = User::find($id);
                return response()->json($user);
            }
            public function update_user(Request $req)
            { 
                $user= User::find($req->get('id'));
                { $validate = $req->validate([
                    'ids'=> 'required',
                    'nama'=> 'required',
                    'username'=> 'required',
                    'email'=> 'required',
                    'password'=> 'required',
                    'roles_id'=> 'required',
                ]);
                $user->id_status = $req->get('ids');
                $user->name = $req->get('nama');
                $user->username = $req->get('username');
                $user->email = $req->get('email');
                $user->password = Hash::make($req->get('password'));
                $user->roles_id = $req->get('roles_id');
                $user->email_verified_at = null;
                $user->remember_token = null;
                $user->save();
                Session::flash('status', 'Ubah data Pengguna berhasil!!!');
                return redirect()->route('sarana.pengguna');
            }
            }
            public function delete_user($id)
            {
                $user = User::find($id);
                $user->delete();
        
                $success = true;
                $message = "Data Pengguna Berhasil Dihapus";
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                ]);
            }

     public function laporan()
    {
        $user = Auth::user();
        return view('sarana.laporan', compact( 'user'));
    }
    public function print(Request $req){
        $validate = $req->validate([
            'dari_tanggal'=> 'required',
            'sampai_tanggal'=> 'required',
        ]);
        $user = Auth::user();
        if($req->get('status')=="Baik"){
            $inventaris = Inventaris::where('kode','!=',null)->whereBetween('tanggal', [$req->get('dari_tanggal'),$req->get('sampai_tanggal')])->get();
            $tanggal = Carbon::now();
            $profile = User::where('roles_id',1)->paginate(1);
            $profile1 = User::where('roles_id',2)->paginate(1);
            $kondisi = $req->get('status');
            $pdf = PDF::loadview('sarana.print',['inventaris'=>$inventaris,'tanggal'=>$tanggal, 'kondisi'=>$kondisi,'profile'=>$profile,'profile1'=>$profile1]);
            return $pdf->stream('laporan.pdf');
        }
        elseif($req->get('status')=="Rusak Ringan"){
            $inventaris = PemeliharaanDetail::where('status',$req->get('status'))->whereBetween('created_at', [$req->get('dari_tanggal'),$req->get('sampai_tanggal')])->get();
            $tanggal = Carbon::now();
            $profile = User::where('roles_id',1)->paginate(1);
            $profile1 = User::where('roles_id',2)->paginate(1);
            $kondisi = $req->get('status');
            $pdf = PDF::loadview('sarana.print2',['inventaris'=>$inventaris,'tanggal'=>$tanggal, 'kondisi'=>$kondisi,'profile'=>$profile,'profile1'=>$profile1]);
            return $pdf->stream('laporan.pdf');
        }
        elseif($req->get('status')=="Rusak Berat"){
            $inventaris = PemeliharaanDetail::where('status',$req->get('status'))->whereBetween('created_at', [$req->get('dari_tanggal'),$req->get('sampai_tanggal')])->get();
            $tanggal = Carbon::now();
            $profile = User::where('roles_id',1)->paginate(1);
            $profile1 = User::where('roles_id',2)->paginate(1);
            $kondisi = $req->get('status');
            $pdf = PDF::loadview('kepala.print2',['inventaris'=>$inventaris,'tanggal'=>$tanggal, 'kondisi'=>$kondisi,'profile'=>$profile,'profile1'=>$profile1]);
            return $pdf->stream('sarana.pdf');
        }
        elseif($req->get('status')=="Habis"){
            $inventaris = PemeliharaanDetail::where('status',$req->get('status'))->whereBetween('created_at', [$req->get('dari_tanggal'),$req->get('sampai_tanggal')])->get();
            $tanggal = Carbon::now();
            $profile = User::where('roles_id',1)->paginate(1);
            $profile1 = User::where('roles_id',2)->paginate(1);
            $kondisi = $req->get('status');
            $pdf = PDF::loadview('sarana.print2',['inventaris'=>$inventaris,'tanggal'=>$tanggal, 'kondisi'=>$kondisi,'profile'=>$profile,'profile1'=>$profile1]);
            return $pdf->stream('laporan.pdf');
        }
        elseif($req->get('status')=="Hilang"){
            $inventaris = PemeliharaanDetail::where('status',$req->get('status'))->whereBetween('created_at', [$req->get('dari_tanggal'),$req->get('sampai_tanggal')])->get();
            $tanggal = Carbon::now();
            $profile = User::where('roles_id',1)->paginate(1);
            $profile1 = User::where('roles_id',2)->paginate(1);
            $kondisi = $req->get('status');
            $pdf = PDF::loadview('sarana.print2',['inventaris'=>$inventaris,'tanggal'=>$tanggal, 'kondisi'=>$kondisi,'profile'=>$profile,'profile1'=>$profile1]);
            return $pdf->stream('laporan.pdf');
        }
        elseif($req->get('status')=="lpj"){
            $pengadaan = Pengadaan::whereBetween('created_at', [$req->get('dari_tanggal'),$req->get('sampai_tanggal')])->get();
            $pengadaandetail = PengadaanDetail::whereBetween('created_at', [$req->get('dari_tanggal'),$req->get('sampai_tanggal')])->where('status',1)->get();
            $tanggal = Carbon::now();
            $profile = User::where('roles_id',1)->paginate(1);
            $profile1 = User::where('roles_id',2)->paginate(1);
            $total = Pengadaan::whereBetween('created_at', [$req->get('dari_tanggal'),$req->get('sampai_tanggal')])->sum('harga');
            $jumlah = PengadaanDetail::whereBetween('created_at', [$req->get('dari_tanggal'),$req->get('sampai_tanggal')])->where('status',1)->sum('total');
            $sisa = $total-$jumlah;
            $pdf = PDF::loadview('sarana.lpj',['pengadaan'=>$pengadaan,'pengadaandetail'=>$pengadaandetail,'total'=>$total,'sisa'=>$sisa,'tanggal'=>$tanggal, 'profile'=>$profile,'profile1'=>$profile1]);
            return $pdf->stream('lpj.pdf');
        }
        
    }
}
