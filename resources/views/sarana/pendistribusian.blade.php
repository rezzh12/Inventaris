@extends('sarana.layouts.master')

@section('title', 'Data Pendistribusian')
@section('judul', 'Data Pendistribusian')
@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">{{ __('Pengelolaan Pendistribusian') }}</div>
            <div class="card-body">
                <table id="table-data" class="table table-striped table-white ">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>Kode</th>
                            <th>Tanggal Pendistribusian</th>
                            <th>Penerima</th>
                            <th>Pengadaan</th>
                            <th>Ruangan</th>
                            <th>Keterangan</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($pendistribusian as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->kode}}</td>
                                <td>{{ $row->tanggal_pendistribusian}}</td>
                                <td>{{ $row->penerima }}</td>
                                <td>{{ $row->pengadaan->tanggal_pengadaan}}</td>
                                <td>{{ $row->ruangan->nama_ruangan }}</td>
                                @if($row->keterangan == 1 )
                                <td>Diterima</td>
                                @else
                                <td>Belum Diterima</td>
                                @endif
                                <td>
                                    @if ($row->keterangan == null && $row->penerima == auth()->user()->name)
                                    <a href="pendistribusian/terima/{{$row->id}}" class="btn btn-success">Terima</a>
                                            @else
                                            @endif
                                           <a href="pendistribusian/detail/{{$row->id}}" class="btn btn-info">Detail</a>
                                    </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data Pendistribusian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('sarana.pendistribusian.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="edit-tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="edit-tanggal" required readonly/>
                        </div>
                        <div class="form-group">
                        <label for="edit-penerima">Penerima</label>
                            <select name="penerima" id="edit-penerima" class="form-control"required>
                                <option value="">Pilih Penerima </option>
                                @foreach($staff as $st)
                            <option value="{{$st->name}}">{{$st->name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                        <label for="edit-ruangan">Ruangan</label>
                            <select name="ruangan" id="edit-ruangan" class="form-control"required readonly>
                                <option value="">Pilih Ruangan </option>
                                @foreach($ruangan as $rg)
                            <option value="{{$rg->id}}">{{$rg->nama_ruangan}}</option>
                            @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="pengadaan" id="edit-pengadaan" />
                <input type="hidden" name="kode" id="edit-kode" />
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
                    url: "{{ url('sarana/ajaxadmin/dataPendistribusian') }}/" + id,
                    dataType: 'json',
                    success: function(res) {
                        $('#edit-tanggal').val(res.tanggal_pendistribusian);
                        $('#edit-ruangan').val(res.ruangan_id);
                        $('#edit-penerima').val(res.penerima);
                        $('#edit-keterangan').val(res.keterangan);
                        $('#edit-pengadaan').val(res.pengadaan_id);
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