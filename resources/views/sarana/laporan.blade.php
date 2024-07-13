@extends('sarana.layouts.master')
@section('title', 'Laporan')
@section('judul', 'Laporan')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Input Data Laporan</div>

                <div class="card-body">
                <form method="post" action="{{ route('sarana.laporan.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                     
                        <div class="form-group">
                            <label for="dari_tanggal">Dari Tanggal</label>
                            <input type="date" class="form-control" name="dari_tanggal" id="dari_tanggal" required />
                        </div>
                        <div class="form-group">
                            <label for="sampai_tanggal">Sampai Tanggal</label>
                            <input type="date" class="form-control" name="sampai_tanggal" id="sampai_tanggal" required /> 
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
                                <option value="lpj">Pertanggung Jawaban </option>
                            </select>
                        </div>
            </div>
            </div>

            <div class="modal-footer">
          
            <a href="{{ URL::previous() }}" class="btn btn-default">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
        </div>
    </div>
</div>
@stop