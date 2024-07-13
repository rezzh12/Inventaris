@extends('user.layouts.master')

@section('title', 'Data Sarana')
@section('judul', 'Data Sarana')
@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">{{ __('Pengelolaan Sarana') }}</div>
            <div class="card-body">
                <table id="table-data" class="table table-striped table-white ">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Merek</th>
                            <th>Kategori</th>
                            <th>Foto</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($sarana as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->kode}}</td>
                                <td>{{ $row->tanggal}}</td>
                                <td>{{ $row->merek}}</td>
                                <td>{{ $row->kategori}}</td>
                                <td>
                                    @if ($row->foto !== null)
                                        <img src="{{ asset('storage/sarana/' . $row->foto) }}" width="100px" />
                                    @else
                                        [Gambar tidak tersedia]
                                    @endif
                                </td>
                                <td>{{ $row->nama_barang}}</td>
                                <td>{{ $row->harga }}</td>
                                <td>{{ $row->keterangan }}</td>
                                <td>{{ $row->jumlah }}</td>                       
                                <td>
                                  
                                        <button type="button" id="btn-edit-jadwal" class="btn btn-success"
                                            data-toggle="modal" data-target="#editMasukModal"
                                            data-id="{{ $row->id }}"><i class="fa fa-edit"></i>Ajukan Peminjaman</button>
                                           
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!--Ubah Data-->
     <!-- UBAH DATA -->
     <div class="modal fade" id="editMasukModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data Peminjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('user.peminjaman.submit') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="edit-tanggal_peminjaman">Tanggal Peminjaman</label>
                            <input type="date" class="form-control" name="tanggal_peminjaman" id="edit-tanggal_peminjaman" required />
                        </div>
                        <div class="form-group">
                            <label for="edit-tanggal_pengembalian">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" name="tanggal_pengembalian" id="edit-tanggal_pengembalian" required />
                        </div>
                        <div class="form-group">
                            <label for="edit-keterangan">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="edit-keterangan" required />
                        </div>
                        <div class="form-group">
                            <label for="edit-jumlah">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="edit-jumlah" required />
                        </div>

                </div>
                <div class="modal-footer">
                <input type="hidden" name="kode" id="edit-kode" />
                <input type="hidden" name="id" id="edit-id" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Ajukan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @stop

    @section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
$(function() {
            $(document).on('click', '#btn-edit-jadwal', function() {
                let id = $(this).data('id');
                $.ajax({
                    type: "get",
                    url: "{{ url('admin/sarana/ajaxadmin/dataSarana') }}/" + id,
                    dataType: 'json',
                    success: function(res) {
                        $('#edit-tanggal').val(res.tanggal);
                        $('#edit-merek').val(res.merek);
                        $('#edit-kategori').val(res.kategori);
                        $('#edit-nama').val(res.nama_barang);
                        $('#edit-old_foto').val(res.foto);
                        $('#edit-harga').val(res.harga);
                        
                        $('#edit-kode').val(res.kode);
                        $('#edit-id').val(res.id);
                    },
                });
            });
        });

        @if(session('status'))
            Swal.fire({
                title: 'Congratulations!',
                text: "{{ session('status') }}",
                icon: 'Success',
                timer: 3000
            })
        @endif
        @if($errors->any())
            @php
                $message = '';
                foreach($errors->all() as $error)
                {
                    $message .= $error."<br/>";
                }
            @endphp
            Swal.fire({
                title: 'Error',
                html: "{!! $message !!}",
                icon: 'error',
            })
        @endif
        
        function deleteConfirmation(npm, judul) {
            swal.fire({
                title: "Hapus?",
                type: 'warning',
                text: "Apakah anda yakin akan menghapus data dengan kode " + judul + "?!",

                showCancelButton: !0,
                confirmButtonText: "Ya, lakukan!",
                cancelButtonText: "Tidak, batalkan!",
                reverseButtons: !0
            }).then(function(e) {

                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'POST',
                        url: "sarana/delete/" + npm,
                        data: {
                            _token: CSRF_TOKEN
                        },
                        dataType: 'JSON',
                        success: function(results) {
                            if (results.success === true) {
                                swal.fire("Selamat", results.message, "success");
                                // refresh page after 2 seconds
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function(dismiss) {
                return false;
            })
        }


    </script>
    @stop