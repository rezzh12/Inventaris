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

class KepalaSekolahController extends Controller
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
        $data4 = StokGudang::count();
        return view('kepala.home', compact('user','data1','data2','data3','data4'));
    }
    public function perencanaan()
    {
        $user = Auth::user();
        $perencanaan = Perencanaan::where('status','=','Diajukan')->with('ruangan','user')->get();
        $ruangan = Ruangan::all();
        return view('kepala.perencanaan', compact( 'user','perencanaan','ruangan'));
    }
    public function perencanaan_detail($id)
    {
        $user = Auth::user();
        $perencanaan = Perencanaan::where('id',$id)->get();
        $perencanaan_detail = PerencanaanDetail::where('perencanaan_id',$id)->get();
        return view('kepala.perencanaan_detail', compact( 'user','perencanaan_detail','perencanaan'));
    }
    public function terima_perencanaan($id){
        $terima = DB::table('perencanaans')->where('id', $id)->update(['keterangan' => 'Disetujui', ]);
        $cek1 = Pengadaan::where('perencanaan_id', $id)->value('kode');
        $id1 = Perencanaan::where('id', $id)->value('id');
        $tanggal = Perencanaan::where('id', $id)->value('tanggal_perencanaan');
        $user = Perencanaan::where('id', $id)->value('user_id');
        $ruangan = Perencanaan::where('id', $id)->value('ruangan_id');
        $total = PerencanaanDetail::where('perencanaan_id', $id)->sum('total');
        $detail = PerencanaanDetail::where('perencanaan_id', $id)->get();
        if($cek1 == null){
            $id = IdGenerator::generate(['table' => 'pengadaans','field'=>'kode', 'length' => 7, 'prefix' =>'PG']);
        $pengadaan = new Pengadaan;
        $pengadaan->kode = $id;
        $pengadaan->tanggal_pengadaan = $tanggal;
        $pengadaan->keterangan = "Pengajuan Sudah Disetujui Segera Lakukan Pengadaan";
        $pengadaan->harga = $total;
        $pengadaan->user_id = $user;
        $pengadaan->perencanaan_id = $id1;
        $pengadaan->ruangan_id =$ruangan;;
        $pengadaan->save();
            foreach ($detail as $d){
                $pengadaan_id = Pengadaan::where('kode', $id)->value('id');
                $pengadaandetail = new PengadaanDetail;
                $pengadaandetail->qty = $d->qty;
                $pengadaandetail->harga = $d->harga;
                $pengadaandetail->total = $d->total;
                $pengadaandetail->merk =$d->merk;
                $pengadaandetail->status =0;
                $pengadaandetail->barang_id =$d->barang_id;
                $pengadaandetail->pengadaan_id =$pengadaan_id;
                $pengadaandetail->save();
            }
       
        Session::flash('status', 'Pengajuan Berhasil Disetujui!!!');
          }else{
            Session::flash('status', 'Pengajuan Berhasil Disetujui!!!');
          }
        
        return redirect()->back();
    }
    public function tolak_perencanaan($id){
        $terima = DB::table('perencanaans')->where('id', $id)->update([ 'keterangan' => 'Ditolak',]);
        Session::flash('status', 'Pengajuan Berhasil Ditolak!!!');
        return redirect()->back();
    }
    public function laporan()
    {
        $user = Auth::user();
        return view('kepala.laporan', compact( 'user'));
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
            $pdf = PDF::loadview('kepala.print',['inventaris'=>$inventaris,'tanggal'=>$tanggal, 'kondisi'=>$kondisi,'profile'=>$profile,'profile1'=>$profile1]);
            return $pdf->stream('laporan.pdf');
        }
        elseif($req->get('status')=="Rusak Ringan"){
            $inventaris = PemeliharaanDetail::where('status',$req->get('status'))->whereBetween('created_at', [$req->get('dari_tanggal'),$req->get('sampai_tanggal')])->get();
            $tanggal = Carbon::now();
            $profile = User::where('roles_id',1)->paginate(1);
            $profile1 = User::where('roles_id',2)->paginate(1);
            $kondisi = $req->get('status');
            $pdf = PDF::loadview('kepala.print2',['inventaris'=>$inventaris,'tanggal'=>$tanggal, 'kondisi'=>$kondisi,'profile'=>$profile,'profile1'=>$profile1]);
            return $pdf->stream('laporan.pdf');
        }
        elseif($req->get('status')=="Rusak Berat"){
            $inventaris = PemeliharaanDetail::where('status',$req->get('status'))->whereBetween('created_at', [$req->get('dari_tanggal'),$req->get('sampai_tanggal')])->get();
            $tanggal = Carbon::now();
            $profile = User::where('roles_id',1)->paginate(1);
            $profile1 = User::where('roles_id',2)->paginate(1);
            $kondisi = $req->get('status');
            $pdf = PDF::loadview('kepala.print2',['inventaris'=>$inventaris,'tanggal'=>$tanggal, 'kondisi'=>$kondisi,'profile'=>$profile,'profile1'=>$profile1]);
            return $pdf->stream('laporan.pdf');
        }
        elseif($req->get('status')=="Habis"){
            $inventaris = PemeliharaanDetail::where('status',$req->get('status'))->whereBetween('created_at', [$req->get('dari_tanggal'),$req->get('sampai_tanggal')])->get();
            $tanggal = Carbon::now();
            $profile = User::where('roles_id',1)->paginate(1);
            $profile1 = User::where('roles_id',2)->paginate(1);
            $kondisi = $req->get('status');
            $pdf = PDF::loadview('kepala.print2',['inventaris'=>$inventaris,'tanggal'=>$tanggal, 'kondisi'=>$kondisi,'profile'=>$profile,'profile1'=>$profile1]);
            return $pdf->stream('laporan.pdf');
        }
        elseif($req->get('status')=="Hilang"){
            $inventaris = PemeliharaanDetail::where('status',$req->get('status'))->whereBetween('created_at', [$req->get('dari_tanggal'),$req->get('sampai_tanggal')])->get();
            $tanggal = Carbon::now();
            $profile = User::where('roles_id',1)->paginate(1);
            $profile1 = User::where('roles_id',2)->paginate(1);
            $kondisi = $req->get('status');
            $pdf = PDF::loadview('kepala.print2',['inventaris'=>$inventaris,'tanggal'=>$tanggal, 'kondisi'=>$kondisi,'profile'=>$profile,'profile1'=>$profile1]);
            return $pdf->stream('laporan.pdf');
        }
        
    }
    public function inventaris()
            {
                $user = Auth::user();
                $inventaris = Inventaris::where('jumlah','!=',0)->with('barang')->get();
                return view('kepala.inventaris', compact( 'user','inventaris'));
            }
}