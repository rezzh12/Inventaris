@extends('staff.layouts.master')

@section('title', 'Data Inventaris')
@section('judul', 'Data Inventaris')
@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">{{ __('Pengelolaan Inventaris') }}</div>
            <div class="card-body">
                <table id="table-data" class="table table-striped table-white ">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>Kode Inventaris</th>
                            <th>Tanggal</th>
                            <th>Sumber Dana</th>
                            <th>Ruangan</th>
                            <th>Nama Barang</th>
                            <th>Merk</th>
                            <th>Jumlah</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($inventaris as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->kode}}</td>
                                <td>{{ $row->tanggal}}</td>
                                <td>{{ $row->keterangan}}</td>
                                <td>{{ $row->ruangan }}</td>
                                <td>{{ $row->barang->nama_barang }}</td>
                                <td>{{ $row->merk }}</td>
                                <td>{{ $row->jumlah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop