@extends('staff.layouts.master')

@section('title', 'Data Pengajuan')
@section('judul', 'Data Pengajuan')
@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">{{ __('Pengelolaan Pengajuan') }}</div>
            <div class="card-body">
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahMasukModal"><i class="fa fa-plus"></i>
                    Tambah Data</button>
                    <hr />
                <table id="table-data" class="table table-striped table-white ">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>Kode Pengajuan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Ruangan</th>

                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($perencanaan as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->kode}}</td>
                                <td>{{ $row->tanggal_perencanaan}}</td>
                                <td>{{ $row->ruangan->nama_ruangan }}</td>
                                
                                <td>{{ $row->status }}</td>
                                <td>{{ $row->keterangan }}</td>
                               
                                
                                <td>
                                    @if ($row->keterangan == null)
                                    @if ($row->status == "Belum Diajukan")
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" id="btn-edit-jadwal" class="btn btn-success"
                                            data-toggle="modal" data-target="#editMasukModal"
                                            data-id="{{ $row->id }}"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs"></button>
                                            <button type="button" class="btn btn-danger"
                                            onclick="deleteConfirmation('{{ $row->id }}', '{{ $row->kode }}' )"><i class="fa fa-times"></i></button>
                                            <button class="btn btn-xs"></button>
                                            @else
                                            @endif
                                            @endif
                                           <a href="perencanaan/detail/{{$row->id}}" class="btn btn-info">Detail</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('staff.perencanaan.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" required />
                        </div>
                        <div class="form-group">
                        <label for="ruangan">Ruangan</label>
                            <select name="ruangan" id="ruangan" class="form-control"required>
                                <option value="">Pilih Ruangan </option>
                                @foreach($ruangan as $rg)
                            <option value="{{$rg->id}}">{{$rg->nama_ruangan}}</option>
                            @endforeach
                            </select>
                        </div>
                       

                </div>
                <div class="modal-footer">
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
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('staff.perencanaan.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="edit-tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="edit-tanggal" required />
                        </div>
                        <div class="form-group">
                        <label for="edit-ruangan">Ruangan</label>
                            <select name="ruangan" id="edit-ruangan" class="form-control"required>
                                <option value="">Pilih Ruangan </option>
                                @foreach($ruangan as $rg)
                            <option value="{{$rg->id}}">{{$rg->nama_ruangan}}</option>
                            @endforeach
                            </select>
                        </div>
                      
                </div>
                <div class="modal-footer">
                <input type="hidden" name="old_foto" id="edit-old_foto" />
                <input type="hidden" name="kode" id="edit-kode" />
                <input type="hidden" name="status" id="edit-status" />
                <input type="hidden" name="keterangan" id="edit-keterangan" />
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
                    url: "{{ url('sarana/ajaxadmin/dataPerencanaan') }}/" + id,
                    dataType: 'json',
                    success: function(res) {
                        $('#edit-tanggal').val(res.tanggal_perencanaan);
                        $('#edit-ruangan').val(res.ruangan_id);
                        $('#edit-status').val(res.status);
                        $('#edit-keterangan').val(res.keterangan);
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
                        url: "perencanaan/delete/" + npm,
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