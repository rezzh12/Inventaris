@extends('sarana.layouts.master')

@section('title', 'Data Pendistribusian Detail')
@section('judul', 'Data Pendistribusian Detail')
@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">{{ __('Pengelolaan Pendistribusian Detail') }}</div>
            <div class="card-body">
                <table id="table-data" class="table table-striped table-white ">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>Barang</th>
                            <th>Merk</th>
                            <th>Jumlah</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($pendistribusian_detail as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->barang->nama_barang}}</td>
                                <td>{{ $row->merk}}</td>
                                <td>{{ $row->qty }}</td>
                               
                                
                             
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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