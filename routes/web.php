<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('sarana/home',
    [App\Http\Controllers\WksBidSaranaController::class, 'index'])->name('sarana.home')->middleware('Sarana');

Route::get('sarana/ruangan',
    [App\Http\Controllers\WksBidSaranaController::class, 'ruangan'])->name('sarana.ruangan')->middleware('Sarana');
Route::post('sarana/ruangan', 
    [App\Http\Controllers\WksBidSaranaController::class, 'submit_ruangan'])->name('sarana.ruangan.submit')->middleware('Sarana');
Route::patch('sarana/ruangan/update', 
    [App\Http\Controllers\WksBidSaranaController::class, 'update_ruangan'])->name('sarana.ruangan.update')->middleware('Sarana');
Route::get('sarana/ajaxadmin/dataRuangan/{id}', 
    [App\Http\Controllers\WksBidSaranaController::class, 'getDataRuangan']);
Route::post('sarana/ruangan/delete/{id}',
    [App\Http\Controllers\WksBidSaranaController::class, 'delete_ruangan'])->name('sarana.ruangan.delete')->middleware('Sarana');

Route::get('sarana/kategori',
    [App\Http\Controllers\WksBidSaranaController::class, 'kategori'])->name('sarana.kategori')->middleware('Sarana');
Route::post('sarana/kategori', 
    [App\Http\Controllers\WksBidSaranaController::class, 'submit_kategori'])->name('sarana.kategori.submit')->middleware('Sarana');
Route::patch('sarana/kategori/update', 
    [App\Http\Controllers\WksBidSaranaController::class, 'update_kategori'])->name('sarana.kategori.update')->middleware('Sarana');
Route::get('sarana/ajaxadmin/dataKategori/{id}', 
    [App\Http\Controllers\WksBidSaranaController::class, 'getDataKategori']);
Route::post('sarana/kategori/delete/{id}',
    [App\Http\Controllers\WksBidSaranaController::class, 'delete_kategori'])->name('sarana.kategori.delete')->middleware('Sarana');

Route::get('sarana/barang',
    [App\Http\Controllers\WksBidSaranaController::class, 'barang'])->name('sarana.barang')->middleware('Sarana');
Route::post('sarana/barang', 
    [App\Http\Controllers\WksBidSaranaController::class, 'submit_barang'])->name('sarana.barang.submit')->middleware('Sarana');
Route::patch('sarana/barang/update', 
    [App\Http\Controllers\WksBidSaranaController::class, 'update_barang'])->name('sarana.barang.update')->middleware('Sarana');
Route::get('sarana/ajaxadmin/dataBarang/{id}', 
    [App\Http\Controllers\WksBidSaranaController::class, 'getDataBarang']);
Route::post('sarana/Barang/delete/{id}',
    [App\Http\Controllers\WksBidSaranaController::class, 'delete_barang'])->name('sarana.barang.delete')->middleware('Sarana');

Route::get('sarana/perencanaan',
    [App\Http\Controllers\WksBidSaranaController::class, 'perencanaan'])->name('sarana.perencanaan')->middleware('Sarana');
Route::post('sarana/perencanaan', 
    [App\Http\Controllers\WksBidSaranaController::class, 'submit_perencanaan'])->name('sarana.perencanaan.submit')->middleware('Sarana');
Route::patch('sarana/perencanaan/update', 
    [App\Http\Controllers\WksBidSaranaController::class, 'update_perencanaan'])->name('sarana.perencanaan.update')->middleware('Sarana');
Route::get('sarana/ajaxadmin/dataPerencanaan/{id}', 
    [App\Http\Controllers\WksBidSaranaController::class, 'getDataPerencanaan']);
Route::post('sarana/perencanaan/delete/{id}',
    [App\Http\Controllers\WksBidSaranaController::class, 'delete_perencanaan'])->name('sarana.perencanaan.delete')->middleware('Sarana');

Route::get('sarana/perencanaan/detail/{id}',
    [App\Http\Controllers\WksBidSaranaController::class, 'perencanaan_detail'])->name('sarana.perencanaan.detail')->middleware('Sarana');
Route::post('sarana/perencanaan/detail', 
    [App\Http\Controllers\WksBidSaranaController::class, 'submit_perencanaan_detail'])->name('sarana.perencanaan.detail.submit')->middleware('Sarana');
Route::patch('sarana/perencanaan/detail/update', 
    [App\Http\Controllers\WksBidSaranaController::class, 'update_perencanaan_detail'])->name('sarana.perencanaan.detail.update')->middleware('Sarana');
Route::get('sarana/ajaxadmin/dataPerencanaanDetail/{id}', 
    [App\Http\Controllers\WksBidSaranaController::class, 'getDataPerencanaanDetail']);
Route::post('sarana/perencanaan/detail/delete/{id}',
    [App\Http\Controllers\WksBidSaranaController::class, 'delete_perencanaan_detail'])->name('sarana.perencanaan.detail.delete')->middleware('Sarana');

Route::get('sarana/pengadaan',
    [App\Http\Controllers\WksBidSaranaController::class, 'pengadaan'])->name('sarana.pengadaan')->middleware('Sarana');
Route::get('sarana/pengadaan/distribusikan/{id}',
    [App\Http\Controllers\WksBidSaranaController::class, 'distribusikan'])->name('sarana.pengadaan.detail')->middleware('Sarana');
Route::get('sarana/pengadaan/detail/{id}',
    [App\Http\Controllers\WksBidSaranaController::class, 'pengadaan_detail'])->name('sarana.pengadaan.detail')->middleware('Sarana');
Route::get('sarana/ajaxadmin/dataPengadaanDetail/{id}', 
    [App\Http\Controllers\WksBidSaranaController::class, 'getDataPengadaanDetail']);
Route::patch('sarana/pengadaan/detail/update', 
    [App\Http\Controllers\WksBidSaranaController::class, 'update_pengadaan_detail'])->name('sarana.pengadaan.detail.update')->middleware('Sarana');
Route::get('sarana/pengadaan/detail/setujui/{id}',
    [App\Http\Controllers\WksBidSaranaController::class, 'setujui_pengadaan_detail'])->name('sarana.setujui.pengadaan.detail')->middleware('Sarana');
    
Route::get('sarana/pendistribusian',
    [App\Http\Controllers\WksBidSaranaController::class, 'pendistribusian'])->name('sarana.pendistribusian')->middleware('Sarana');
Route::patch('sarana/pendistribusian/update',
    [App\Http\Controllers\WksBidSaranaController::class, 'pendistribusian_update'])->name('sarana.pendistribusian.update')->middleware('Sarana');
Route::get('sarana/ajaxadmin/dataPendistribusian/{id}', 
    [App\Http\Controllers\WksBidSaranaController::class, 'getDataPendistribusian']);
Route::get('sarana/pendistribusian/detail/{id}',
    [App\Http\Controllers\WksBidSaranaController::class,'pendistribusian_detail'])->name('sarana.pendistribusian.detail')->middleware('Sarana');
    Route::get('sarana/pendistribusian/terima/{id}',
    [App\Http\Controllers\WksBidSaranaController::class,'pendistribusian_terima'])->name('sarana.pendistribusian.terima')->middleware('Sarana');

Route::get('sarana/inventaris',
    [App\Http\Controllers\WksBidSaranaController::class, 'inventaris'])->name('sarana.inventaris')->middleware('Sarana');
Route::patch('sarana/inventaris/update', 
    [App\Http\Controllers\WksBidSaranaController::class, 'update_inventaris'])->name('sarana.inventaris.update')->middleware('Sarana');
Route::get('sarana/ajaxadmin/dataInventaris/{id}', 
    [App\Http\Controllers\WksBidSaranaController::class, 'getDataInventaris']);

Route::get('sarana/pemeliharaan',
    [App\Http\Controllers\WksBidSaranaController::class, 'pemeliharaan'])->name('sarana.pemeliharaan')->middleware('Sarana');
Route::post('sarana/pemeliharaan', 
    [App\Http\Controllers\WksBidSaranaController::class, 'submit_pemeliharaan'])->name('sarana.pemeliharaan.submit')->middleware('Sarana');
Route::patch('sarana/pemeliharaan/update', 
    [App\Http\Controllers\WksBidSaranaController::class, 'update_pemeliharaan'])->name('sarana.pemeliharaan.update')->middleware('Sarana');
Route::get('sarana/ajaxadmin/dataPemeliharaan/{id}', 
    [App\Http\Controllers\WksBidSaranaController::class, 'getDataPemeliharaan']);
Route::post('sarana/pemeliharaan/delete/{id}',
    [App\Http\Controllers\WksBidSaranaController::class, 'delete_pemeliharaan'])->name('sarana.pemeliharaan.delete')->middleware('Sarana');

Route::get('sarana/pemeliharaan/detail/{id}',
    [App\Http\Controllers\WksBidSaranaController::class, 'pemeliharaan_detail'])->name('sarana.pemeliharaan.detail')->middleware('Sarana');
Route::post('sarana/pemeliharaan/detail', 
    [App\Http\Controllers\WksBidSaranaController::class, 'submit_pemeliharaan_detail'])->name('sarana.pemeliharaan.detail.submit')->middleware('Sarana');
Route::patch('sarana/pemeliharaan/detail/update', 
    [App\Http\Controllers\WksBidSaranaController::class, 'update_pemeliharaan_detail'])->name('sarana.pemeliharaan.detail.update')->middleware('Sarana');
Route::get('sarana/ajaxadmin/dataPemeliharaanDetail/{id}', 
    [App\Http\Controllers\WksBidSaranaController::class, 'getDataPemeliharaanDetail']);
Route::post('sarana/pemeliharaan/detail/delete/{id}',
    [App\Http\Controllers\WksBidSaranaController::class, 'delete_pemeliharaan_detail'])->name('sarana.pemeliharaan.detail.delete')->middleware('Sarana');

Route::get('sarana/stok_gudang',
    [App\Http\Controllers\WksBidSaranaController::class, 'stock_gudang'])->name('sarana.stock.gudang')->middleware('Sarana');
    Route::get('sarana/laporan',
    [App\Http\Controllers\WksBidSaranaController::class, 'laporan'])->name('sarana.laporan')->middleware('Sarana');
    Route::post('sarana/laporan',
    [App\Http\Controllers\WksBidSaranaController::class, 'print'])->name('sarana.laporan.submit');
    
Route::get('sarana/user',
    [App\Http\Controllers\WksBidSaranaController::class, 'data_user'])->name('sarana.pengguna')->middleware('Sarana');
Route::post('sarana/user', 
    [App\Http\Controllers\WksBidSaranaController::class, 'submit_user'])->name('sarana.pengguna.submit')->middleware('Sarana');
Route::patch('sarana/user/update', 
    [App\Http\Controllers\WksBidSaranaController::class, 'update_user'])->name('sarana.pengguna.update')->middleware('Sarana');
Route::post('sarana/user/delete/{id}',
    [App\Http\Controllers\WksBidSaranaController::class, 'delete_user'])->name('sarana.pengguna.delete')->middleware('Sarana');
Route::get('sarana/ajaxadmin/dataUser/{id}', 
    [App\Http\Controllers\WksBidSaranaController::class, 'getDataUser']);

    Route::get('kepala/home',
    [App\Http\Controllers\KepalaSekolahController::class, 'index'])->name('kepala.home')->middleware('Kepala');
    Route::get('kepala/perencanaan',
    [App\Http\Controllers\KepalaSekolahController::class, 'perencanaan'])->name('kepala.perencanaan')->middleware('Kepala');
    Route::get('kepala/perencanaan/terima/{id}',
    [App\Http\Controllers\KepalaSekolahController::class, 'terima_perencanaan'])->name('kepsek.perencanaan.terima')->middleware('Kepala');
    Route::get('kepala/perencanaan/tolak/{id}',
    [App\Http\Controllers\KepalaSekolahController::class, 'tolak_perencanaan'])->name('kepsek.perencanaan.tolak')->middleware('Kepala');
    Route::get('kepala/perencanaan/detail/{id}',
    [App\Http\Controllers\KepalaSekolahController::class, 'perencanaan_detail'])->name('kepala.perencanaan.detail')->middleware('Kepala');
    Route::get('kepala/inventaris',
    [App\Http\Controllers\KepalaSekolahController::class, 'inventaris'])->name('kepala.inventaris')->middleware('Kepala');
    Route::get('kepala/laporan',
    [App\Http\Controllers\KepalaSekolahController::class, 'laporan'])->name('kepala.laporan')->middleware('Kepala');
    Route::post('kepala/laporan',
    [App\Http\Controllers\KepalaSekolahController::class, 'print'])->name('kepala.laporan.submit');
    

Route::get('staff/home',
    [App\Http\Controllers\StaffController::class, 'index'])->name('staff.home')->middleware('Staff');
Route::get('staff/perencanaan',
    [App\Http\Controllers\StaffController::class, 'perencanaan'])->name('staff.perencanaan')->middleware('Staff');
Route::post('staff/perencanaan', 
    [App\Http\Controllers\StaffController::class, 'submit_perencanaan'])->name('staff.perencanaan.submit')->middleware('Staff');
Route::patch('staff/perencanaan/update', 
    [App\Http\Controllers\StaffController::class, 'update_perencanaan'])->name('staff.perencanaan.update')->middleware('Staff');
Route::get('staff/ajaxadmin/dataPerencanaan/{id}', 
    [App\Http\Controllers\StaffController::class, 'getDataPerencanaan']);
Route::post('staff/perencanaan/delete/{id}',
    [App\Http\Controllers\StaffController::class, 'delete_perencanaan'])->name('staff.perencanaan.delete')->middleware('Staff');

Route::get('staff/perencanaan/detail/{id}',
    [App\Http\Controllers\StaffController::class, 'perencanaan_detail'])->name('staff.perencanaan.detail')->middleware('Staff');
Route::post('staff/perencanaan/detail', 
    [App\Http\Controllers\StaffController::class, 'submit_perencanaan_detail'])->name('staff.perencanaan.detail.submit')->middleware('Staff');
Route::patch('staff/perencanaan/detail/update', 
    [App\Http\Controllers\StaffController::class, 'update_perencanaan_detail'])->name('staff.perencanaan.detail.update')->middleware('Staff');
Route::get('staff/ajaxadmin/dataPerencanaanDetail/{id}', 
    [App\Http\Controllers\StaffController::class, 'getDataPerencanaanDetail']);
Route::post('staff/perencanaan/detail/delete/{id}',
    [App\Http\Controllers\StaffController::class, 'delete_perencanaan_detail'])->name('staff.perencanaan.detail.delete')->middleware('Staff');

Route::get('staff/pendistribusian',
    [App\Http\Controllers\StaffController::class, 'pendistribusian'])->name('staff.pendistribusian')->middleware('Staff');
Route::patch('staff/pendistribusian/update',
    [App\Http\Controllers\StaffController::class, 'pendistribusian_update'])->name('staff.pendistribusian.update')->middleware('Staff');
Route::get('staff/ajaxadmin/dataPendistribusian/{id}', 
    [App\Http\Controllers\StaffController::class, 'getDataPendistribusian']);
Route::get('staff/pendistribusian/detail/{id}',
    [App\Http\Controllers\StaffController::class,'pendistribusian_detail'])->name('staff.pendistribusian.detail')->middleware('Staff');
Route::get('staff/pendistribusian/terima/{id}',
    [App\Http\Controllers\StaffController::class,'pendistribusian_terima'])->name('staff.pendistribusian.terima')->middleware('Staff');

Route::get('staff/inventaris',
    [App\Http\Controllers\StaffController::class, 'inventaris'])->name('staff.inventaris')->middleware('Staff');

Route::get('staff/pemeliharaan',
    [App\Http\Controllers\StaffController::class, 'pemeliharaan'])->name('staff.pemeliharaan')->middleware('Staff');
Route::post('staff/pemeliharaan', 
    [App\Http\Controllers\StaffController::class, 'submit_pemeliharaan'])->name('staff.pemeliharaan.submit')->middleware('Staff');
Route::patch('staff/pemeliharaan/update', 
    [App\Http\Controllers\StaffController::class, 'update_pemeliharaan'])->name('staff.pemeliharaan.update')->middleware('Staff');
Route::get('staff/ajaxadmin/dataPemeliharaan/{id}', 
    [App\Http\Controllers\StaffController::class, 'getDataPemeliharaan']);
Route::post('staff/pemeliharaan/delete/{id}',
    [App\Http\Controllers\StaffController::class, 'delete_pemeliharaan'])->name('staff.pemeliharaan.delete')->middleware('Staff');

Route::get('staff/pemeliharaan/detail/{id}',
    [App\Http\Controllers\StaffController::class, 'pemeliharaan_detail'])->name('staff.pemeliharaan.detail')->middleware('Staff');
Route::post('staff/pemeliharaan/detail', 
    [App\Http\Controllers\StaffController::class, 'submit_pemeliharaan_detail'])->name('staff.pemeliharaan.detail.submit')->middleware('Staff');
Route::patch('staff/pemeliharaan/detail/update', 
    [App\Http\Controllers\StaffController::class, 'update_pemeliharaan_detail'])->name('staff.pemeliharaan.detail.update')->middleware('Staff');
Route::get('staff/ajaxadmin/dataPemeliharaanDetail/{id}', 
    [App\Http\Controllers\StaffController::class, 'getDataPemeliharaanDetail']);
Route::post('staff/pemeliharaan/detail/delete/{id}',
    [App\Http\Controllers\StaffController::class, 'delete_pemeliharaan_detail'])->name('staff.pemeliharaan.detail.delete')->middleware('Staff');