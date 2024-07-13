@extends('user.layouts.master')

@section('title', 'Data Riwayat Denda')
@section('judul', 'Data Riwayat Denda')
@section('content')
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">{{ __('Pengelolaan Riwayat Denda') }}</div>
            <div class="card-body">
                    <hr />
                <table id="table-data" class="table table-striped table-white ">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>Tanggal</th>
                            <th>Kode Pengembalian</th>
                            <th>Peminjam</th>
                            <th>Denda</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($denda as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->tanggal}}</td>
                                <td>{{ $row->kode_pengembalian}}</td>
                                <td>{{ $row->nama}}</td>
                                <td>{{ $row->denda }}</td>
                                <td>Dibayar</td>                       
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @stop