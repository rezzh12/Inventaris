@extends('staff.layouts.master')

@section('title', 'Data Pemeliharaan Detail')
@section('judul', 'Data Pemeliharaan Detail')
@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">{{ __('Pengelolaan Pemeliharaan Detail') }}</div>
            <div class="card-body">
                @if ($petugas == auth()->user()->name)
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahMasukModal"><i class="fa fa-plus"></i>
            @else
            @endif
                    Tambah Data</button>
                    <hr />
                <table id="table-data" class="table table-striped table-white ">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>Kode Inventaris</th>
                            <th>Barang</th>
                            <th>status</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($pemeliharaan_detail as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->inventaris->kode}}</td>
                                <td>{{ $row->barang->nama_barang}}</td>
                                <td>{{ $row->status }}</td>
                                <td>{{ $row->jumlah }}</td>
                                <td>{{ $row->keterangan }}</td>
                                <td>
                                @if ($petugas == auth()->user()->name)
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" id="btn-edit-jadwal" class="btn btn-success"
                                            data-toggle="modal" data-target="#editMasukModal"
                                            data-id="{{ $row->id }}"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs"></button>
                                            <button type="button" class="btn btn-danger"
                                            onclick="deleteConfirmation('{{ $row->id }}', '{{ $row->barang->nama_barang}}' )"><i class="fa fa-times"></i></button>
                                            <button class="btn btn-xs"></button>
                                            @else
            @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tambah Jadwal -->
    <div class="modal fade" id="tambahMasukModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pemeliharaan Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('staff.pemeliharaan.detail.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                        <label for="inventaris">Inventaris</label>
                            <select name="inventaris" id="inventaris" class="form-control"required>
                                <option value="">Pilih inventaris </option>
                                @foreach($inventaris as $in)
                                <option value="{{$in->id}}">{{$in->kode}} {{$in->barang->nama_barang}} </option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                        <label for="status">Status</label>
                            <select name="status" id="status" class="form-control"required>
                                <option value="">Pilih Status </option>
                                <option value="Baik">Baik </option>
                                <option value="Rusak Ringan">Rusak Ringan </option>
                                <option value="Rusak Berat">Rusak Berat </option>
                                <option value="Habis">Habis </option>
                                <option value="Hilang">Hilang </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlah" required />
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan" required />
                        </div>

                </div>
                <div class="modal-footer">
                @foreach ($pemeliharaan as $pm)
                <input type="hidden" name="pemeliharaan" id="pemeliharaan" value="{{$pm->id}}" />
                @endforeach
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Ubah Data-->
     <!-- UBAH DATA -->
     <div class="modal fade" id="editMasukModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data Pemeliharaan Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('staff.pemeliharaan.detail.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                        <label for="edit-inventaris">Inventaris</label>
                            <select name="inventaris" id="edit-inventaris" class="form-control"required>
                                <option value="">Pilih inventaris </option>
                                @foreach($inventaris as $in)
                            <option value="{{$in->id}}">{{$in->kode}} {{$in->barang->nama_barang}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                        <label for="edit-status">Status</label>
                            <select name="status" id="edit-status" class="form-control"required>
                                <option value="">Pilih Status </option>
                                <option value="Baik">Baik </option>
                                <option value="Rusak Ringan">Rusak Ringan </option>
                                <option value="Rusak Berat">Rusak Berat </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-jumlah">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="edit-jumlah" required />
                        </div>
                        <div class="form-group">
                            <label for="edit-keterangan">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="edit-keterangan" required />
                        </div>

                </div>
                <div class="modal-footer">
                @foreach ($pemeliharaan as $pm)
                <input type="hidden" name="pemeliharaan" id="pemeliharaan" value="{{$pm->id}}" />
                @endforeach
                <input type="hidden" name="id" id="edit-id" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Ubah</button>
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
                    url: "{{ url('sarana/ajaxadmin/dataPemeliharaanDetail') }}/" + id,
                    dataType: 'json',
                    success: function(res) {
                        $('#edit-inventaris').val(res.inventaris_id);
                        $('#edit-status').val(res.status);
                        $('#edit-jumlah').val(res.qty);
                        $('#edit-keterangan').val(res.keterangan);
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
                text: "Apakah anda yakin akan menghapus data dengan nama " + judul + "?!",

                showCancelButton: !0,
                confirmButtonText: "Ya, lakukan!",
                cancelButtonText: "Tidak, batalkan!",
                reverseButtons: !0
            }).then(function(e) {

                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'POST',
                        url: "delete/" + npm,
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