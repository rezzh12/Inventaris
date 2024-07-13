@extends('sarana.layouts.master')

@section('title', 'Data Pengadaan Detail')
@section('judul', 'Data Pengadaan Detail')
@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">{{ __('Pengelolaan Pengadaan Detail') }}</div>
            <div class="card-body">
                <table id="table-data" class="table table-striped table-white ">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>Barang</th>
                            <th>Merk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>total</th>
                            <th>Status</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($pengadaan_detail as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->barang->nama_barang}}</td>
                                <td>{{ $row->merk}}</td>
                                <td>{{ $row->qty }}</td>
                                <td>{{ $row->harga }}</td>
                                <td>{{ $row->total }}</td>
                                <td>@if($row->status == 0)
                                    <span>Belum Dilakukan Pengadaan</span>
                                    @else 
                                    <span>Sudah Dilakukan Pengadaan</span>
                                    @endif
                                </td>
                               
                                
                                <td>
                                @if($row->status == 0)
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="setujui/{{$row->id}}" class="btn btn-primary"><i class="fa fa-check"></i></a>
                                    <button class="btn btn-xs"></button>
                                        <button type="button" id="btn-edit-jadwal" class="btn btn-success"
                                            data-toggle="modal" data-target="#editMasukModal"
                                            data-id="{{ $row->id }}"><i class="fa fa-edit"></i></button>
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

    <div class="modal fade" id="editMasukModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data Pengadaan Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('sarana.pengadaan.detail.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                        <label for="edit-barang">Barang</label>
                            <select name="barang" id="edit-barang" class="form-control"required readonly>
                                @foreach($barang as $bg)
                            <option value="{{$bg->id}}">{{$bg->nama_barang}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-merk">Merk</label>
                            <input type="text" class="form-control" name="merk" id="edit-merk" required />
                        </div>
                        <div class="form-group">
                            <label for="edit-jumlah">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="edit-jumlah" required readonly/>
                        </div>
                        <div class="form-group">
                            <label for="edit-harga">Harga</label>
                            <input type="number" class="form-control" name="harga" id="edit-harga" required readonly/>
                        </div>
                       
                </div>
                <div class="modal-footer">
                <input type="hidden" name="kode" id="edit-kode" />
                <input type="hidden" name="status" id="edit-status" />
                @foreach ($pengadaan as $pr)
                <input type="hidden" name="pengadaan" id="pengadaan" value="{{$pr->id}}" />
                @endforeach
              
                <input type="hidden" name="id" id="edit-id" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Ubah</button>
                    </form>
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
                    url: "{{ url('sarana/ajaxadmin/dataPengadaanDetail') }}/" + id,
                    dataType: 'json',
                    success: function(res) {
                        $('#edit-barang').val(res.barang_id);
                        $('#edit-merk').val(res.merk);
                        $('#edit-jumlah').val(res.qty);
                        $('#edit-harga').val(res.harga);
                        $('#edit-status').val(res.status);
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